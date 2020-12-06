@extends('app')

@section('title', 'Login')

@section('main')
<section>
    <h1>Log In</h1>
    <form action="https://webtech.local:8080/users/login" method="post">
        <div>
            <label for="logInName">Name: </label>
            <input type="text" id="logInName" name="name" />
        </div>
        <div>
            <label for="logInPassword">Password: </label>
            <input type="password" id="logInPassword" name="password" />
        </div>
        <button type="submit">Log in</button>
    </form>
</section>
<section>
    <h1>Register</h1>
    <form>
        <div>
            <label for="registerName">Name: </label>
            <input type="text" id="registerName" name="name" />
        </div>
        <div>
            <label for="registerEmail">Email: </label>
            <input type="email" id="registerEmail" name="email" />
        </div>
        <div>
            <label for="registerPassword">Password: </label>
            <input type="password" id="registerPassword" name="password" />
        </div>
        <button type="submit">Register</button>
    </form>
</section>
@endsection
