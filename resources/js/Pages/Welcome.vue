<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    cv: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <Head :title="cv ? cv.full_name + ' এর সিভি' : 'No CV Available'" />

    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div v-if="cv" class="max-w-3xl w-full bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col items-center text-center mb-8">
                <img v-if="cv.profile_picture" :src="'/storage/' + cv.profile_picture" alt="Profile Picture" class="w-40 h-40 object-cover rounded-full mb-4 border-4 border-blue-400">
                <img v-else src="/images/default-profile.png" alt="Default Profile" class="w-40 h-40 object-cover rounded-full mb-4 border-4 border-blue-400">

                <h1 class="text-4xl font-bold text-gray-900">{{ cv.full_name }}</h1>
                <p class="text-gray-600 mt-2">{{ cv.email }} | {{ cv.phone }} | {{ cv.address }}</p>
                <div class="mt-2 space-x-4">
                    <a v-if="cv.linkedin_url" :href="cv.linkedin_url" target="_blank" class="text-blue-600 hover:underline">LinkedIn</a>
                    <a v-if="cv.github_url" :href="cv.github_url" target="_blank" class="text-gray-800 hover:underline">GitHub</a>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Summary</h2>
                <p class="text-gray-700">{{ cv.summary }}</p>
            </div>

            <div v-if="cv.education?.length" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Education</h2>
                <ul class="space-y-4">
                    <li v-for="(edu, index) in cv.education" :key="index">
                        <h3 class="text-lg font-medium text-gray-900">{{ edu.degree }}</h3>
                        <p class="text-gray-700">{{ edu.institution }} ({{ edu.year }})</p>
                    </li>
                </ul>
            </div>

            <div v-if="cv.experience?.length" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Experience</h2>
                <ul class="space-y-4">
                    <li v-for="(exp, index) in cv.experience" :key="index">
                        <h3 class="text-lg font-medium text-gray-900">{{ exp.title }} at {{ exp.company }}</h3>
                        <p class="text-gray-700">{{ exp.duration }}</p>
                        <p class="text-gray-700">{{ exp.description }}</p>
                    </li>
                </ul>
            </div>

            <div v-if="cv.skills?.length" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    <span v-for="(skill, index) in cv.skills" :key="index" class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">{{ skill }}</span>
                </div>
            </div>

            <div v-if="cv.projects?.length" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Projects</h2>
                <ul class="space-y-4">
                    <li v-for="(project, index) in cv.projects" :key="index">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a v-if="project.url" :href="project.url" target="_blank" class="text-blue-600 hover:underline">{{ project.name }}</a>
                            <span v-else>{{ project.name }}</span>
                        </h3>
                        <p class="text-gray-700">{{ project.description }}</p>
                    </li>
                </ul>
            </div>

            <div v-if="cv.awards?.length" class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 border-b-2 border-blue-400 pb-2 mb-4">Awards</h2>
                <ul class="space-y-4">
                    <li v-for="(award, index) in cv.awards" :key="index">
                        <h3 class="text-lg font-medium text-gray-900">{{ award.name }}</h3>
                        <p class="text-gray-700">{{ award.issuer }} ({{ award.year }})</p>
                    </li>
                </ul>
            </div>

            <div class="mt-8 text-center text-gray-500 text-sm">
                Powered by Laravel & Vue.js
            </div>
        </div>
        <div v-else class="text-center text-gray-600">
            <p>No CV available for display.</p>
            <p class="mt-2 text-sm">Please ensure a user with ID 1 exists and has a CV assigned.</p>
        </div>
    </div>
</template>
