@extends('layouts.app')
@section('content')
<form method='POST' action='{{ route("categories.store") }}'>@csrf<input name='name'><button>Create</button></form>
@endsection