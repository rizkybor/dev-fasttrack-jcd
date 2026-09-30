<script setup>
import { computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { useI18n } from 'vue-i18n';
import FaqAccordionSection from '@/Components/FaqAccordionSection.vue';

const { t, locale } = useI18n();

const props = defineProps({
    faqGroups: {
        type: Array,
        default: () => [],
    },
});

// Helper: pick nilai berdasarkan locale aktif, fallback ke 'id'
const pick = (field) => {
    if (field === null || field === undefined) return field;
    if (
        typeof field === 'object' &&
        !Array.isArray(field) &&
        ('id' in field || 'en' in field || 'zh' in field)
    ) {
        return field[locale.value] ?? field.id ?? field;
    }
    return field;
};

const localizedGroups = computed(() =>
    props.faqGroups.map((group) => ({
        title: pick(group.title),
        faq: (group.faq?.[locale.value] ?? group.faq?.id ?? []),
    })),
);
</script>

<template>
    <MainLayout>
        <section class="bg-white py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">{{ t('faq.tag') }}</p>
                    <h1 class="mt-4 text-4xl font-extrabold text-secondary md:text-5xl">{{ t('faq.title') }}</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        {{ t('faq.desc') }}
                    </p>
                </div>

                <div v-if="localizedGroups.length" class="mt-12 space-y-8">
                    <div v-for="group in localizedGroups" :key="group.title">
                        <FaqAccordionSection :faq="group.faq" :title="group.title" />
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
