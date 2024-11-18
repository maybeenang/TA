@props([
    "active",
])

<a
    {{ $attributes->merge(["class" => "block text-white w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium  hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out"]) }}
>
    {{ $slot }}
</a>
