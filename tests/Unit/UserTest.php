// Create a new User
   $user = new User;
   $user->email = "login@email.com";
   $user->password = "password";

   // User should not save
   $this->assertFalse($user->save());

   // Save the errors
   $errors = $user->errors()->all();

   // There should be 1 error
   $this->assertCount(1, $errors);

   // The username error should be set
   $this->assertEquals($errors[0], "The username field is required.");

   the test above is for usename required