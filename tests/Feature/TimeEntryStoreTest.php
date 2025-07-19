<?php

use App\Models\TimeEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;

// The RefreshDatabase trait resets the database after each test,
// ensuring a clean state for every test run.
uses(RefreshDatabase::class);

// Test 1: Check if a valid time entry can be successfully created.
it('can store a new time entry and returns the updated table fragment', function () {
    // Arrange: Define the valid data for the new time entry.
    $entryData = [
        'entry_date' => '2025-07-15',
        'start_time' => '09:00',
        'end_time' => '17:00',
        'notes' => 'A test note.',
    ];

    // Act: Send a POST request to the 'entries.store' route with the data.
    $response = $this->post(route('entries.store'), $entryData);

    // Assert: Check that the request was successful and the data is correct.
    $response->assertOk();
    $response->assertSee('A test note.'); // Check if the note appears in the returned fragment.
    $response->assertSee('Jul 15');      // Check for the formatted date.

    // Assert that the entry exists in the database with the correct values.
    $this->assertDatabaseHas('time_entries', [
        'entry_date' => '2025-07-15',
        'start_time' => '09:00',
        'end_time' => '17:00',
        'notes' => 'A test note.',
    ]);

    // Assert that exactly one record was created.
    expect(TimeEntry::count())->toBe(1);
});

// Test 2: Ensure that the 'entry_date' must be unique.
it('validates that entry_date is unique', function () {
    // Arrange: Create an initial entry with a specific date.
    TimeEntry::create([
        'entry_date' => '2025-07-15',
        'start_time' => '08:00',
        'end_time' => '10:00',
    ]);

    // Define data for a new entry with the same date.
    $entryData = [
        'entry_date' => '2025-07-15',
        'start_time' => '11:00',
        'end_time' => '12:00',
        'notes' => 'Trying to create a duplicate date.',
    ];

    // Act: Attempt to post the new entry.
    // Assert: Check that the session has a validation error for 'entry_date'.
    $this->post(route('entries.store'), $entryData)
        ->assertSessionHasErrors('entry_date');
});

// Test 3: Use a dataset to test multiple validation rules at once.
// This is a clean way to test all your validation rules from StoreTimeEntryRequest.
test('validation fails for invalid data', function (array $data, string|array $errors) {
    // Act: Post the invalid data to the store route.
    // Assert: Check for the expected validation errors in the session.
    $this->post(route('entries.store'), $data)
        ->assertSessionHasErrors($errors);
})->with([
    'entry_date is required' => fn () => [['entry_date' => ''], 'entry_date'],
    'start_time is required' => fn () => [['start_time' => ''], 'start_time'],
    'end_time is required' => fn () => [['end_time' => ''], 'end_time'],
    'start_time must be a valid time format' => fn () => [['start_time' => 'not-a-time'], 'start_time'],
    'end_time must be a valid time format' => fn () => [['end_time' => 'not-a-time'], 'end_time'],
    'start_time must be before end_time' => fn () => [[
        'entry_date' => '2025-07-15',
        'start_time' => '17:00',
        'end_time' => '09:00',
    ], 'start_time'],
    'end_time must be after start_time' => fn () => [[
        'entry_date' => '2025-07-15',
        'start_time' => '17:00',
        'end_time' => '09:00',
    ], 'end_time'],
    'notes must be a string' => fn () => [['notes' => ['not-a-string']], 'notes'],
    'notes cannot be longer than 255 chars' => fn () => [['notes' => str_repeat('a', 256)], 'notes'],
]);
