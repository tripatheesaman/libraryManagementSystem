<form action="{{route('register')}}" method="post">
    @csrf
<input type="text" name="first_name" id="">
<input type="text" name="last_name" id="">
<input type="email" name="email" id="">
<input type="password" name="password" id="">
<input type="hidden" name="role" value="user">
<input type="submit" value="submit">
</form>