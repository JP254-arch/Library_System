@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded shadow p-6">
  <h2 class="text-2xl font-bold mb-4">Create an account</h2>

  <form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="mb-3">
      <label class="block text-sm font-medium">Name</label>
      <input name="name" value="{{ old('name') }}" class="mt-1 block w-full border rounded p-2" required>
      @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block text-sm font-medium">Email</label>
      <input name="email" type="email" value="{{ old('email') }}" class="mt-1 block w-full border rounded p-2" required>
      @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block text-sm font-medium">Password</label>
      <input name="password" type="password" class="mt-1 block w-full border rounded p-2" required>
      @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block text-sm font-medium">Confirm Password</label>
      <input name="password_confirmation" type="password" class="mt-1 block w-full border rounded p-2" required>
    </div>

    <div class="flex items-center justify-between">
      <button class="px-4 py-2 bg-green-600 text-white rounded">Register</button>
      <a href="{{ route('login') }}" class="text-sm text-blue-600">Already have an account?</a>
    </div>
  </form>
</div>
@endsection
