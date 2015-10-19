@if (! Auth::check())
    <li><a href="/">Homepage</a></li>
    <li><a href="/auth/login">Log In</a></li>
    <li><a href="/auth/register">Register</a></li>
@else
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="/auth/logout">Log Out</a></li>
@endif