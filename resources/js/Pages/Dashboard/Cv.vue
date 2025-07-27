<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    cv: Object,
});

const form = useForm({
    full_name: props.cv?.full_name || '',
    email: props.cv?.email || '',
    phone: props.cv?.phone || '',
    address: props.cv?.address || '',
    summary: props.cv?.summary || '',
    profile_picture: null,
    linkedin_url: props.cv?.linkedin_url || '',
    github_url: props.cv?.github_url || '',
    education: props.cv?.education || [], // Array for dynamic fields
    experience: props.cv?.experience || [],
    skills: props.cv?.skills || [],
    projects: props.cv?.projects || [],
    awards: props.cv?.awards || [],
});

const addEducation = () => {
    form.education.push({ degree: '', institution: '', year: '' });
};
const removeEducation = (index) => {
    form.education.splice(index, 1);
};

const submit = () => {
    form.post(route('dashboard.cv.update'), {
        forceFormData: true,
        onFinish: () => {
            if (form.isDirty) {
                alert('CV updated successfully!');
            }
        },
    });
};
</script>

<template>
    <AppLayout title="Update CV">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                আপনার সিভি হালনাগাদ করুন
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">ব্যক্তিগত তথ্য</h3>
                        <div>
                            <InputLabel for="full_name" value="সম্পূর্ণ নাম" />
                            <TextInput id="full_name" v-model="form.full_name" type="text" class="mt-1 block w-full" required />
                            <InputError class="mt-2" :message="form.errors.full_name" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="email" value="ইমেল" />
                            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="phone" value="ফোন" />
                            <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="address" value="ঠিকানা" />
                            <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="summary" value="সারসংক্ষেপ" />
                            <textarea id="summary" v-model="form.summary" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                            <InputError class="mt-2" :message="form.errors.summary" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="profile_picture" value="প্রোফাইল ছবি" />
                            <input type="file" @input="form.profile_picture = $event.target.files[0]" />
                            <InputError class="mt-2" :message="form.errors.profile_picture" />
                            <img v-if="props.cv?.profile_picture" :src="'/storage/' + props.cv.profile_picture" alt="Profile Picture" class="mt-2 w-20 h-20 object-cover rounded-full">
                        </div>
                        <div class="mt-4">
                            <InputLabel for="linkedin_url" value="লিঙ্কডইন প্রোফাইল" />
                            <TextInput id="linkedin_url" v-model="form.linkedin_url" type="url" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.linkedin_url" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="github_url" value="গিটহাব প্রোফাইল" />
                            <TextInput id="github_url" v-model="form.github_url" type="url" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.github_url" />
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mt-8 mb-4">শিক্ষাগত যোগ্যতা</h3>
                        <div v-for="(edu, index) in form.education" :key="index" class="border p-4 mb-4 rounded-md">
                            <InputLabel :for="'degree-' + index" value="ডিগ্রী" />
                            <TextInput :id="'degree-' + index" v-model="edu.degree" type="text" class="mt-1 block w-full" />
                            <InputLabel :for="'institution-' + index" value="প্রতিষ্ঠান" class="mt-2" />
                            <TextInput :id="'institution-' + index" v-model="edu.institution" type="text" class="mt-1 block w-full" />
                            <InputLabel :for="'year-' + index" value="বছর" class="mt-2" />
                            <TextInput :id="'year-' + index" v-model="edu.year" type="text" class="mt-1 block w-full" />
                            <button type="button" @click="removeEducation(index)" class="text-red-600 text-sm mt-2">মুছুন</button>
                        </div>
                        <PrimaryButton type="button" @click="addEducation">শিক্ষাগত যোগ্যতা যোগ করুন</PrimaryButton>
                        <InputError class="mt-2" :message="form.errors.education" />

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                সিভি সেভ করুন
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
