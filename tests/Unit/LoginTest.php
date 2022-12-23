<?php

namespace Tests\Unit;

use App\Models\userInfo;
use App\Models\Book;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

    }

    public function test_loginUser_with_right_credentials()
    {
        $response = $this->call('post', '/login', ['email' => 'admin@gmail.com', 'password' => 'admin']);

        $response->assertStatus(200)->assertJson(['message' => 'successfully']);

    }

    public function test_loginUser_with_wrong_email_credentials()
    {
        $response = $this->call('post', '/login', ['email' => 'my@gmail.com', 'password' => '12341']);

        $response->assertStatus(200)
            ->assertJson(['error' => 'invalid email']);

    }

    public function test_loginUser_with_wrong_password_credentials()
    {
        $response = $this->call('post', '/login', ['email' => 'admin@gmail.com', 'password' => '12341']);

        $response->assertStatus(200)
            ->assertJson(['error' => 'invalid password']);

    }

    public function test_showUser_data()
    {

        $usersCount = userInfo::with('books')->get()->count();
        $response = $this->withSession(['role' => 'admin'])->call('get', '/showUser');

//        dd(count(json_decode($response->getContent())->users));
        $response->assertStatus(200);
        $this->assertEquals($usersCount, count(json_decode($response->getContent())->users));


    }

    public function test_store_data()
    {
        $response = $this->withSession(['role' => 'admin'])->call('post', '/store', ['username' => 'user', 'email' => 'user@gmail.com', 'role' => 'user']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('userInfo', [
            'username' => 'user',
            'role' => 'user'
        ]);


    }

    public function test_destroy_data()
    {
        $response = $this->withSession(['role' => 'admin'])->call('post', '/store', ['username' => 'main4', 'email' => 'main4@gmail.com', 'role' => 'user']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('userInfo', [
            'username' => 'main4',
            'role' => 'user'
        ]);

        $data = userInfo::where('username', 'main4')->pluck('id');
        $response = $this->withSession(['role' => 'admin'])->call('get', 'delete/' . $data[0]);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('userInfo', [
            'username' => 'main4',
        ]);
    }

    public function test_user_updated()
    {
        $admin = UserInfo::factory()->create(['role' => 'admin']);
        $this->assertDatabaseHas('userInfo', [
            'username' => $admin->username,
            'email' => $admin->email,
            "role" => 'admin'
        ]);

        $response = $this->withSession(['role' => 'admin'])->call('get', '/edit/' . $admin->id);
        $response->assertStatus(200);
        $this->assertEquals($admin->username, json_decode($response->getContent())->student->username);


        $response = $this->put('update/', [
            'id' => $admin->id,
            'username' => $admin->username,
            'email' => $admin->email,
            "role" => 'user'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('userInfo', [
            'username' => $admin->username,
            'email' => $admin->email,
            "role" => 'user'
        ]);
    }



    public function test_store_book(){


        $admin = UserInfo::factory()->create(['role'=>'admin']);

       $this->assertDatabaseHas('userInfo',[
       'id'=>$admin->id,
       'username' =>$admin->username,
        'email'=>$admin->email,
        'role'=>$admin->role,
    ]);


       $response = $this->withSession(['role' => 'admin'])->call('POST','/addBook',[
            'title'=>'jack1',
            'AuthorName'=>'karl1',
            'Cost'=>'5001',
            'quantity'=>'31'
            ]);
        $response->assertStatus(200);
        $this->assertTrue(true);

    }

    public function test_edit_book(){
        $admin = UserInfo::factory()->create(['role'=>'admin']);

        $response = $this->withSession(['role' => 'admin'])->call('post', '/login', ['email' => $admin->email, 'password' => 'password']);
        $response->assertStatus(200);

        $response = $this->withSession(['role' => 'admin'])->call('POST','/addBook',[
            'title'=>'jack12',
            'AuthorName'=>'karl12',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

         $response->assertStatus(200);

          $this->assertDatabaseHas('books',[
            'title'=>'jack12',
            'AuthorName'=>'karl12',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

        $data = Book::where('title','jack12')->first();


        $editResponse = $this->call('get', '/editBook/'.$data->id);

        $editResponse->assertStatus(200);
        $this->assertTrue(true);


    }



    public function test_delete_book()
    {
        $admin = UserInfo::factory()->create(['role'=>'admin']);

        $response = $this->withSession(['role' => 'admin'])->call('post', '/login', ['email' => $admin->email, 'password' => 'password']);
        $response->assertStatus(200);

        $response = $this->withSession(['role' => 'admin'])->call('POST','/addBook',[
            'title'=>'jack12',
            'AuthorName'=>'karl12',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books',[
            'title'=>'jack12',
            'AuthorName'=>'karl12',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

        $data = Book::where('title','jack12')->first();


        $deleteResponse = $this->call('get', '/deleteBook/'.$data->id);


        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('books', [
            'title' => 'jack12',
        ]);
        $this->assertTrue(true);
    }

    public function test_update_book()
    {
        $admin = UserInfo::factory()->create(['role'=>'admin']);

        $response = $this->withSession(['role' => 'admin'])->call('post', '/login', ['email' => $admin->email, 'password' => 'password']);
        $response->assertStatus(200);

        $response = $this->withSession(['role' => 'admin'])->call('POST','/addBook',[
            'title'=>'jack13',
            'AuthorName'=>'karl13',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books',[
            'title'=>'jack13',
            'AuthorName'=>'karl13',
            'Cost'=>'50',
            'quantity'=>'3'
        ]);

        $data = Book::where('title','jack13')->first();


        $response = $this->put('updateBook/', [
            'title' => 'Azad',
            'AuthorName' => $data->AuthorName,
            'Cost' => $data->Cost,
            "quantity" => 9
        ]);
        $response->assertStatus(200);
    }



    public function test_login_normal_user()
      {
          $user = UserInfo::factory()->create(['role'=>'user']);

          $response = $this->withSession(['role' => 'user'])->call('post', '/login', ['email' => $user->email, 'password' => 'password']);
          $response->assertStatus(200);
      }

      public function test_edit_user_profile()
      {

          $user = UserInfo::factory()->create(['role'=>'user']);
          $response = $this->call('post', '/login', ['email' => $user->email, 'password' => 'password']);
          $response->assertStatus(200);
         $response->assertSessionHas(['id']);
      }

      public function test_update_user_profile()
      {
          $user = UserInfo::factory()->create(['role'=>'user']);
          $response = $this->withSession(['role' => 'user','id'=>'id'])->call('post', '/login', ['email' => $user->email, 'password' => 'password']);
          $response->assertStatus(200);
          $response->assertSessionHas(['id']);
          $updateResponse =
          $response = $this->put('updateProfile', [
                'username'=>'fghj',
              'email'=>'bnm@fgh.bn',
              'password'=>'fghj',
          ]);
          $response->assertStatus(200);

          $this->assertDatabaseHas('userInfo', [
              'username'=>'fghj',
              'email'=>'bnm@fgh.bn',
              'password'=>'fghj',
          ]);

      }




}
