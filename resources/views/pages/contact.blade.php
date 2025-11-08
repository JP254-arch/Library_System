@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16 max-w-6xl">

    <h1 class="text-4xl font-bold mb-8 text-indigo-600 text-center">📚 Contact Lexicon</h1>
    <p class="text-gray-700 text-center mb-12 max-w-2xl mx-auto">
        Have questions, suggestions, or ideas about our library? Reach out to Lexicon using the form or the contact info provided.
    </p>

    <div class="flex flex-col lg:flex-row gap-10">

        {{-- Left: Contact Form --}}
        <div class="lg:w-1/2">
            <form action="#" method="POST" class="bg-white shadow-xl rounded-2xl p-8 space-y-6 border border-gray-100">
                @csrf

                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                    <input type="text" name="name" id="name" placeholder="e.g. Jane Doe"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="e.g. jane@lexicon.com"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
                </div>

                <div>
                    <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                    <textarea name="message" id="message" rows="5" placeholder="Type your message here..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all">
                    ✉️ Send Message
                </button>
            </form>
        </div>

        {{-- Right: Contact Info --}}
        <div class="lg:w-1/2 flex flex-col justify-center text-gray-600 space-y-4 bg-indigo-50 p-8 rounded-2xl shadow-inner">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Or reach us directly:</h2>
            <p>Email: <a href="mailto:info@lexicon.com" class="text-orange-600 hover:underline">info@lexicon.com</a></p>
            <p>Phone: <a href="tel:+1234567890" class="text-orange-600 hover:underline">+1 (234) 567-890</a></p>
            <p>Address: 123 Lexicon Library St, Knowledge City</p>
            <p class="mt-4 text-sm text-gray-500">Lexicon Library, where knowledge meets curiosity.</p>
        </div>

    </div>

</div>
@endsection
