<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hawk Prints</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">HAWK<span class="text-blue-600">PRINTS</span></h1>
            <p class="text-gray-500 mt-2">Admin Panel Login</p>
        </div>
        
        @if($errors->any())
        <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>
            
            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                Login
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700">← Back to Website</a>
        </div>
    </div>
</body>
</html>