
<h3>Login</h3>

<form action="{{route('login')}}" method="post">
    @csrf
    <input type="email" placeholder="email" name="email">
    <input type="password" placeholder="password" name="password">
    <input type="submit" value="Login">
</form>
