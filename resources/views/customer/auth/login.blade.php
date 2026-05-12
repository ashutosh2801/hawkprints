@extends('layouts.app')

@section('title', 'Login - Five Rivers Print')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-700 text-white p-6 text-center">
                <h2 class="text-2xl font-bold">Welcome Back</h2>
                <p class="text-blue-100 mt-1">Sign in to your account</p>
            </div>
            
            <form method="POST" action="{{ route('customer.login.submit') }}" class="p-8">
                @csrf
                
                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="{{ route('customer.forgot-password') }}" class="text-sm text-blue-600 hover:text-blue-800">Forgot password?</a>
                </div>

                <button type="submit" class="w-full bg-blue-700 text-white py-3 rounded-lg font-bold hover:bg-blue-800 transition">
                    Sign In
                </button>

                <p class="text-center mt-6 text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('customer.register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection