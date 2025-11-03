@extends('layouts.app')
@section('content')
<form method='POST' action='{{ route("authors.store") }}'>@csrf<input name='name'><button>Create</button></form>
@endsection