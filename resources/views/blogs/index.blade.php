@extends('layouts.app')

@section('content')
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>@yield('title', 'Blog News')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Section -->
    <header class="flex items-center justify-between mb-12">
      <div class="text-center lg:text-left">
        <h1 class="text-6xl font-extrabold text-gray-900 mb-2">Kabar UNTIRTA</h1>
        <p class="text-xl text-gray-600">Sumber Berita Terpercaya dan Terkini</p>
      </div>

      <!-- User Info & Logout Menu -->
      @auth
      <div class="flex items-center space-x-6">
        <span class="text-lg text-gray-800 font-semibold">Hello, {{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800">
                <i class="fa-solid fa-right-from-bracket text-2xl"></i>
            </button>
        </form>
      </div>
      @endauth
    </header>

    <!-- Admin and User-specific Search Section -->
    @auth
      @if(auth()->user()->role !== 'admin')
        <div class="text-center mb-8">
          <form action="{{ route('blogs.index') }}" method="GET" class="max-w-2xl mx-auto">
            <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}" class="px-4 py-2 w-full rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"/>
            <button type="submit" class="mt-2 w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
              <i class="fa-solid fa-search"></i> Cari
            </button>
          </form>
        </div>
      @endif
    @endauth

    <!-- Admin Button for Creating Blog -->
    @auth
      @if(auth()->user()->role === 'admin')
        <div class="mb-8 text-center">
          <a href="{{ route('blogs.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
            <i class="fa-solid fa-plus-circle"></i> Create New Blog
          </a>
        </div>
      @endif
    @endauth

    <!-- Main News Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Main Article -->
      <div class="lg:col-span-2">
        @foreach($blogs as $blog)
        <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-8 hover:shadow-2xl transition duration-300">
          <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover"/>
          <div class="p-6">
            <h3 class="text-3xl font-semibold text-gray-800 hover:text-blue-600 transition duration-300">
              <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
            </h3>
            <p class="text-sm text-gray-500 mt-2">by {{ $blog->author }} - {{ $blog->created_at->format('M d, Y') }}</p>
            <p class="text-gray-700 mt-4">{{ Str::limit($blog->content, 200) }}</p>
            <div class="mt-4 text-right">
              <a href="{{ route('blogs.show', $blog) }}" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-300">Read more</a>
            </div>
            
            <!-- Edit and Delete Buttons for Admin -->
            @auth
              @if(auth()->user()->role === 'admin')
                <div class="flex space-x-4 mt-4">
                  <!-- Edit Button -->
                  <a href="{{ route('blogs.edit', $blog) }}" class="text-yellow-600 hover:text-yellow-800">
                    <i class="fa-solid fa-edit"></i> Edit
                  </a>
                  
                  <!-- Delete Button -->
                  <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">
                      <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              @endif
            @endauth
          </div>
        </div>
        @endforeach
      </div>

      <!-- Sidebar Section (Optional) -->
      <div>
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
          <div class="p-6">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Popular Articles</h4>
            @foreach($blogs as $blog)
            <div class="flex space-x-4 mb-6">
              <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-24 h-16 object-cover"/>
              <div>
                <h5 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition duration-300">
                  <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                </h5>
                <p class="text-sm text-gray-500">{{ $blog->created_at->format('M d, Y') }}</p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
@endsection
