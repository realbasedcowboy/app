<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { BreadcrumbItem } from '@/types';

import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Card, CardContent } from '@/components/ui/card';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Upload new meme', href: '/meme' },
];

const form = useForm({
    title: '',
    description: '',
    image: null as File | null,
});

const previewUrl = ref<string | null>(null);

function handleImageChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
}

function resetForm() {
    form.reset();
    previewUrl.value = null;

    // Clear the file input manually
    const input = document.getElementById('image') as HTMLInputElement | null;
    if (input) input.value = '';
}

function submit() {
    form.post(route('meme.store'), {
        forceFormData: true,
        onSuccess: () => {
            resetForm();
            toast.success('Your meme has been published');
        }
    });
}
</script>

<template>
    <Head title="Upload Meme" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold">Upload a Meme</h1>

            <Card>
                <CardContent class="p-6 space-y-4">
                    <form @submit.prevent="submit" class="space-y-4">
                        <!-- Title -->
                        <div>
                            <Label for="title">Title</Label>
                            <Input
                                id="title"
                                v-model="form.title"
                                placeholder="Funny meme title"
                            />
                            <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <Label for="description">Description</Label>
                            <Textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Optional description"
                                rows="4"
                            />
                            <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <Label for="image">Image</Label>
                            <Input
                                id="image"
                                type="file"
                                accept="image/*"
                                @change="handleImageChange"
                            />
                            <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">
                                {{ form.errors.image }}
                            </p>
                        </div>

                        <!-- Preview -->
                        <div v-if="previewUrl" class="mt-4">
                            <Label class="mb-1 block">Preview</Label>
                            <img :src="previewUrl" class="rounded-xl max-h-64 shadow" />
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <Button type="submit" class="w-full" :disabled="form.processing">
                                {{ form.processing ? 'Uploading...' : 'Upload Meme' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
