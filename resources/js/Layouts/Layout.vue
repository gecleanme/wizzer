<template>
    <header class="text-gray-600 body-font">
        <div
            class="container mx-auto flex flex-wrap py-3 px-5 flex-col md:flex-row items-center"
        >
            <Link href="/">
                <img
                    src="/storage/assets/logo.jpg"
                    alt="Logo by DALL-E 3"
                    height="48"
                    width="48"
                />
            </Link>
            <span class="ml-0 mt-0 text-xl md:ml-3 mt-2">Wizzer</span>

            <nav
                class="m-2 md:ml-auto flex flex-wrap items-center text-base justify-center"
            ></nav>
        </div>
    </header>
    <slot></slot>
    <footer class="text-gray-600 body-font">
        <div
            class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col"
        >
            <Link
                href="/"
                class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900"
            >
                <img
                    src="/storage/assets/logo.jpg"
                    alt="Logo by DALL-E 3"
                    height="64"
                    width="64"
                />

                <span class="ml-3 text-xl">Wizzer</span>
            </Link>
            <p
                class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4"
            >
                © 2024 Milad Khader —
                <a
                    href="https://github.com/gecleanme"
                    class="text-gray-600 ml-1"
                    rel="noopener noreferrer"
                    target="_blank"
                    >@gecleanme</a
                >
            </p>

            <p
                class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4"
            >
                <a
                    href="https://openweathermap.org/api"
                    class="text-gray-600 ml-1"
                    rel="noopener noreferrer"
                    target="_blank"
                    >Powered by OpenWeatherMap API</a
                >
            </p>
            <p
                class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4"
            >
                <a
                    href="https://openai.com/dall-e-3"
                    class="text-gray-600 ml-1"
                    rel="noopener noreferrer"
                    target="_blank"
                    >Logo by DALL-E 3
                </a>
            </p>
        </div>
    </footer>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
