<body class="py-5 md:py-0">

@include('components.layouts.header')

<div class="flex overflow-hidden">
    <div class="content">
        <main>
            {{ $slot }}
        </main>
    </div>
</div>


<!-- JAVASCRIPT -->
@stack('modals')

@livewireScripts

</body>
