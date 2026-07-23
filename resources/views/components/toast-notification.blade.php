
{{-- Success Message --}}

@if (session('success'))
    <div class="fixed top-right mt-4 mr-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 opacity-100" id="success-message">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('success-message').style.opacity = '0';
        }, 4000);
    </script>
@endif

@if (session('error'))
    <div class="fixed top-right mt-4 mr-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 opacity-100" id="error-message">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('error-message').style.opacity = '0';
        }, 4000);
    </script>
@endif
