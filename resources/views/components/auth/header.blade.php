<!-- resources/views/components/auth/header.blade.php -->
<div class="auth-header">
    <a href="{{ route('home') }}" class="auth-header-content hover:opacity-80 transition-opacity duration-200" 
       style="text-decoration: none; color: inherit; cursor: pointer; display: flex; align-items: center;">
        <div class="auth-header-logo">
            <img src="{{ asset('images/eeevsu.jpg') }}" alt="EVSU Logo" class="header-logo">
        </div>
        <div class="auth-header-text">
            <h1>{{ $title ?? 'Eastern Visayas State University' }}</h1>
            <p>{{ $subtitle ?? 'School Of Engineering' }}</p>
        </div>
    </a>
</div>