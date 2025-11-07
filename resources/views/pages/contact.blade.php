@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4 text-indigo-600 text-center">Contact Us</h1>
<p class="text-gray-700 text-center mb-6">
    Have questions or suggestions? Reach out to us using the form below.
</p>

<form action="#" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">
    @csrf
    <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
        <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500">
    </div>
    <div class="mb-4">
        <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
        <textarea name="message" id="message" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-500"></textarea>
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-semibold">Send Message</button>
</form>
@endsection
