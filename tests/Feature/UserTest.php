<?php

use App\Models\User;

test('Create user with name, email and password', function () {
    // Arrange
    $data = [
        'name' => 'khalid',
        'email' => 'kha@aa.com',
        'password' => 'password'
    ];

    // Act
    $user = User::create( $data );

    // Assert
    expect( $user->name )->toBe( $data['name'] );
    expect( $user->email )->toBe( $data['email'] );
});

test('Create user that will fail validaiton', function() {
    // Arrange
    $data = [
        'name' => '',
        'email' => 'kk@k.com',
    ];

    // Act
    try {
        $user = User::create( $data );
        $isFaild = false;
    } catch ( Exception $e ) {
        $isFaild = true;
    }

    expect( $isFaild )->toBeTrue();
    expect( User::where('email', $data['email'])->exists() )->toBeFalse();

});
