<script setup>
import { computed } from "vue";
import LocationAutocomplete from "@/Components/LocationAutocomplete.vue";

const props = defineProps(
    { status: Number },
    { title: String | null },
    { description: String | null },
);

const title = computed(() => {
    return {
        503: "503: Service Unavailable",
        500: props.title ?? "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
    }[props.status];
});

const description = computed(() => {
    return {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500:
            props.description ??
            "Server Connection Error, try reloading the page or searching for your city using the above search box",
        404: "Unable to load weather data, try searching for your city using the above search box",
        403: "Sorry, you are forbidden from accessing this page.",
    }[props.status];
});
</script>

<script>
import Layout from "@/Layouts/Layout.vue";

export default {
    layout: Layout,
};
</script>

<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8"
    >
        <div class="max-w-md w-full space-y-8">
            <LocationAutocomplete
                class="mb-8 w-full mx-auto relative autocomplete-container"
            />

            <div class="text-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="w-24 h-24 text-red-500 mx-auto"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>

                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ title }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ description }}
                </p>
            </div>
        </div>
    </div>
</template>
