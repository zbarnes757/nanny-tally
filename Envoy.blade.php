// Envoy.blade.php
@setup
    $user = 'deploy';
    $server = 'your_server_ip';
    $server_address = $user . '@' . $server;

    $repo = 'git@github.com:your-repo/your-project.git';
    $base_dir = '/var/www/nannytally';
    $releases_dir = "{$base_dir}/releases";
    $current_dir = "{$base_dir}/current";
    $shared_dir = "{$base_dir}/shared";
    $new_release_dir = date('YmdHis');
    $php_version = "8.4"
    $php = 'php';
    $composer = 'composer';
@endsetup

@servers(['web' => $server_address])

@story('setup')
    create_directories
    clone_repository
    install_dependencies
    setup_shared_files
    update_symlinks
    set_permissions
    restart_services
@endstory

@story('deploy')
    create_new_release_dir
    clone_repository
    install_dependencies
    setup_shared_files
    update_symlinks
    run_migrations_and_cache
    set_permissions
    restart_services
    cleanup_old_releases
@endstory

@task('create_directories', ['on' => 'web'])
    echo 'Creating project directories...';
    sudo mkdir -p {{ $releases_dir }} {{ $shared_dir }}/storage;
    sudo chown -R {{ $user }}:www-data {{ $base_dir }};
    sudo chmod -R 775 {{ $shared_dir }}/storage;
@endtask

@task('clone_repository', ['on' => 'web'])
    echo 'Cloning repository...';
    cd {{ $releases_dir }};
    git clone --depth 1 {{ $repo }} {{ $new_release_dir }};
@endtask

@task('install_dependencies', ['on' => 'web'])
    echo 'Installing dependencies...';
    cd {{ $releases_dir }}/{{ $new_release_dir }};
    {{ $composer }} install --no-dev --optimize-autoloader;
    npm install;
    npm run build;
@endtask

@task('setup_shared_files', ['on' => 'web'])
    echo 'Setting up shared files...';
    cd {{ $releases_dir }}/{{ $new_release_dir }};
    # Create .env file if it doesn't exist in shared
    if [ ! -f "{{ $shared_dir }}/.env" ]; then
    cp .env.example {{ $shared_dir }}/.env;
    cd {{ $shared_dir }};
    {{ $php }} artisan key:generate;
    echo "Created .env file. Please configure it on the server.";
    fi
    # Link shared storage and .env file
    rm -rf storage;
    ln -nfs {{ $shared_dir }}/storage ./;
    ln -nfs {{ $shared_dir }}/.env ./.env;
@endtask

@task('update_symlinks', ['on' => 'web'])
    echo 'Updating current symlink...';
    ln -nfs {{ $releases_dir }}/{{ $new_release_dir }} {{ $current_dir }};
@endtask

@task('run_migrations_and_cache', ['on' => 'web'])
    echo 'Running migrations and caching...';
    cd {{ $current_dir }};
    {{ $php }} artisan migrate --force;
    {{ $php }} artisan config:cache;
    {{ $php }} artisan route:cache;
    {{ $php }} artisan view:cache;
@endtask

@task('start_queue')

@task('set_permissions', ['on' => 'web'])
    echo 'Setting directory permissions...';
    sudo chown -R {{ $user }}:www-data {{ $releases_dir }}/{{ $new_release_dir }};
    sudo chmod -R 775 {{ $releases_dir }}/{{ $new_release_dir }}/storage;
    sudo chmod -R 775 {{ $releases_dir }}/{{ $new_release_dir }}/bootstrap/cache;
@endtask

@task('restart_services', ['on' => 'web'])
    echo 'Restarting PHP-FPM...';
    sudo systemctl restart php{{ $php_version }}-fpm;
@endtask

@task('cleanup_old_releases', ['on' => 'web'])
    echo 'Cleaning up old releases...';
    cd {{ $releases_dir }};
    ls -dt {{ $releases_dir }}/* | tail -n +6 | xargs -r sudo rm -rf;
@endtask
