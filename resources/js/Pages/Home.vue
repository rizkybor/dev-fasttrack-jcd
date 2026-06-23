<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";
import { useModals } from "@/Composables/useModals";
import GeneratorNamaModal from "@/Components/ModalGenerateName.vue";
import CekNamaModal from "@/Components/ModalCheckName.vue";
import { useServiceCategories } from "@/Data/serviceCategories";
import { useTools } from "@/Data/tools";
import { useVirtualOffices } from "@/Data/virtualOffices";

const { serviceCategories } = useServiceCategories();

const { t } = useI18n();

const {
    showGeneratorModal,
    showCheckNameModal,
    prefillCheckName,
    openGenerator,
    openCheckName,
    closeCheckName,
    transferToCheckName,
} = useModals();

const handleToolClick = (tool) => {
    if (tool.id === "generator-nama") openGenerator();
    if (tool.id === "cek-nama-pt") openCheckName();
};

const marqueeRows = [
    {
        id: 1,
        reverse: false,
        logos: [
            { src: "/images/klien-kami/ft-kk-1-bni.svg", alt: "BNI" },
            { src: "/images/klien-kami/ft-kk-2-hpplaw.svg", alt: "HPP Law" },
            {
                src: "/images/klien-kami/ft-kk-3-traveloka.svg",
                alt: "Traveloka",
            },
            { src: "/images/klien-kami/ft-kk-4-bd.svg", alt: "BD" },
            { src: "/images/klien-kami/ft-kk-5-solenis.svg", alt: "Solenis" },
            { src: "/images/klien-kami/ft-kk-6-holcim.svg", alt: "Holcim" },
            { src: "/images/klien-kami/ft-kk-7-lv.svg", alt: "LV" },
            {
                src: "/images/klien-kami/ft-kk-8-haskoning.svg",
                alt: "Haskoning",
            },
            { src: "/images/klien-kami/ft-kk-9-iss.svg", alt: "ISS" },
            { src: "/images/klien-kami/ft-kk-10-giift.svg", alt: "Giift" },
            { src: "/images/klien-kami/ft-kk-11-xanhsm.svg", alt: "Xan HSM" },
            {
                src: "/images/klien-kami/ft-kk-12-awantunai.svg",
                alt: "Awantunai",
            },
            {
                src: "/images/klien-kami/ft-kk-13-issfacilityservices.svg",
                alt: "ISS Facility Services",
            },
            { src: "/images/klien-kami/ft-kk-14-infinID.svg", alt: "InfinID" },
            { src: "/images/klien-kami/ft-kk-15-glico.svg", alt: "Glico" },
            {
                src: "/images/klien-kami/ft-kk-16-whiteevenbos.svg",
                alt: "Whiteevenbos",
            },
            { src: "/images/klien-kami/ft-kk-17-dimo.svg", alt: "Dimo" },
            {
                src: "/images/klien-kami/ft-kk-18-salestock.svg",
                alt: "Salestock",
            },
            { src: "/images/klien-kami/ft-kk-19-spruson.svg", alt: "Spruson" },
            { src: "/images/klien-kami/ft-kk-20-BKtel.svg", alt: "BK Tel" },
            {
                src: "/images/klien-kami/ft-kk-21-unilever.svg",
                alt: "Unilever",
            },
            { src: "/images/klien-kami/ft-kk-22-its.svg", alt: "ITS" },
            { src: "/images/klien-kami/ft-kk-23-smec.svg", alt: "SMEC" },
            { src: "/images/klien-kami/ft-kk-24-amdocs.svg", alt: "Amdocs" },
            { src: "/images/klien-kami/ft-kk-25-kargo.svg", alt: "Kargo" },
            { src: "/images/klien-kami/ft-kk-26-assegaf.svg", alt: "Assegaf" },
            {
                src: "/images/klien-kami/ft-kk-27-asiafoundation.svg",
                alt: "Asia Foundation",
            },
            { src: "/images/klien-kami/ft-kk-28-apx.svg", alt: "APX" },
        ],
    },
    {
        id: 2,
        reverse: true,
        logos: [
            { src: "/images/klien-kami/ft-kk-29-maka.svg", alt: "Maka" },
            { src: "/images/klien-kami/ft-kk-30-etana.svg", alt: "Etana" },
            { src: "/images/klien-kami/ft-kk-31-brankas.svg", alt: "Brankas" },
            { src: "/images/klien-kami/ft-kk-32-umbra.svg", alt: "Umbra" },
            { src: "/images/klien-kami/ft-kk-33-azo.svg", alt: "Azo" },
            {
                src: "/images/klien-kami/ft-kk-34-australianembassy.svg",
                alt: "Australian Embassy",
            },
            {
                src: "/images/klien-kami/ft-kk-35-yayasankemahpeduli.svg",
                alt: "Yayasan Kemah Peduli",
            },
            { src: "/images/klien-kami/ft-kk-36-hivos.svg", alt: "Hivos" },
            { src: "/images/klien-kami/ft-kk-37-borneo.svg", alt: "Borneo" },
            { src: "/images/klien-kami/ft-kk-38-aspire.svg", alt: "Aspire" },
            { src: "/images/klien-kami/ft-kk-39-ollion.svg", alt: "Ollion" },
            { src: "/images/klien-kami/ft-kk-40-diamond.svg", alt: "Diamond" },
            { src: "/images/klien-kami/ft-kk-41-sonymusic.svg", alt: "Sony" },
            { src: "/images/klien-kami/ft-kk-42-sosro.svg", alt: "Sosro" },
            { src: "/images/klien-kami/ft-kk-43-grab.svg", alt: "Grab" },
            { src: "/images/klien-kami/ft-kk-44-jhonson.svg", alt: "Jhonson" },
            { src: "/images/klien-kami/ft-kk-45-giift.svg", alt: "Giift" },
            { src: "/images/klien-kami/ft-kk-46-hangry.svg", alt: "Hangry" },
            {
                src: "/images/klien-kami/ft-kk-47-tokopedia.svg",
                alt: "Tokopedia",
            },
            { src: "/images/klien-kami/ft-kk-48-stg.svg", alt: "Stg" },
            {
                src: "/images/klien-kami/ft-kk-49-saladstop.svg",
                alt: "Saladstop",
            },
            {
                src: "/images/klien-kami/ft-kk-50-yakiniku.svg",
                alt: "Yakiniku",
            },
            { src: "/images/klien-kami/ft-kk-51-aidenv.svg", alt: "Aidenv" },
            { src: "/images/klien-kami/ft-kk-52-falcon.svg", alt: "Falcon" },
            { src: "/images/klien-kami/ft-kk-53-kalbe.svg", alt: "Kalbe" },
            { src: "/images/klien-kami/ft-kk-54-aurecon.svg", alt: "Aurecon" },
            { src: "/images/klien-kami/ft-kk-55-merck.svg", alt: "Merck" },
            { src: "/images/klien-kami/ft-kk-56-fis.svg", alt: "Fis" },
            { src: "/images/klien-kami/ft-kk-57-goto.svg", alt: "Goto" },
            { src: "/images/klien-kami/ft-kk-58-elano.svg", alt: "Elano" },
        ],
    },
    {
        id: 3,
        reverse: false,
        logos: [
            { src: "/images/klien-kami/ft-kk-59-sem.svg", alt: "Sem" },
            { src: "/images/klien-kami/ft-kk-60-loreal.svg", alt: "Loreal" },
            { src: "/images/klien-kami/ft-kk-61-unox.svg", alt: "Unox" },
            {
                src: "/images/klien-kami/ft-kk-62-bankfama.svg",
                alt: "Bankfama",
            },
            { src: "/images/klien-kami/ft-kk-63-lg.svg", alt: "Lg" },
            { src: "/images/klien-kami/ft-kk-64-newland.svg", alt: "Newland" },
            {
                src: "/images/klien-kami/ft-kk-65-freeport.svg",
                alt: "Freeport",
            },
            {
                src: "/images/klien-kami/ft-kk-66-yayasananakbangsa.svg",
                alt: "Yayasananakbangsa",
            },
            { src: "/images/klien-kami/ft-kk-67-bcg.svg", alt: "Bcg" },
            {
                src: "/images/klien-kami/ft-kk-68-astraland.svg",
                alt: "Astraland",
            },
            { src: "/images/klien-kami/ft-kk-69-arabica.svg", alt: "Arabica" },
            {
                src: "/images/klien-kami/ft-kk-70-dompet-aman.svg",
                alt: "Dompet Aman",
            },
            { src: "/images/klien-kami/ft-kk-71-tiket.svg", alt: "Tiket" },
            { src: "/images/klien-kami/ft-kk-72-aladin.svg", alt: "Aladin" },
            { src: "/images/klien-kami/ft-kk-73-dior.svg", alt: "Dior" },
            { src: "/images/klien-kami/ft-kk-74-vida.svg", alt: "Vida" },
            { src: "/images/klien-kami/ft-kk-75-oue.svg", alt: "Oue" },
            { src: "/images/klien-kami/ft-kk-76-wetv.svg", alt: "Wetv" },
            { src: "/images/klien-kami/ft-kk-77-kraft.svg", alt: "Kraft" },
            { src: "/images/klien-kami/ft-kk-78-mondele.svg", alt: "Mondele" },
            { src: "/images/klien-kami/ft-kk-79-pullman.svg", alt: "Pullman" },
            { src: "/images/klien-kami/ft-kk-80-maeresk.svg", alt: "Maeresk" },
            { src: "/images/klien-kami/ft-kk-81-ovo.svg", alt: "Ovo" },
            { src: "/images/klien-kami/ft-kk-82-camel.svg", alt: "Camel" },
            { src: "/images/klien-kami/ft-kk-83-artotel.svg", alt: "Artotel" },
            { src: "/images/klien-kami/ft-kk-84-tencent.svg", alt: "Tencent" },
            { src: "/images/klien-kami/ft-kk-85-ebay.svg", alt: "Ebay" },
            { src: "/images/klien-kami/ft-kk-86-google.svg", alt: "Google" },
            { src: "/images/klien-kami/ft-kk-87-apple.svg", alt: "Apple" },
        ],
    },
];

const serviceSearch = ref("");

const filteredCategories = computed(() => {
    const categories = serviceCategories.value;
    if (!serviceSearch.value) return categories;
    const q = serviceSearch.value.toLowerCase();
    return categories
        .map((cat) => ({
            ...cat,
            items: cat.items.filter(
                (item) =>
                    item.title.toLowerCase().includes(q) ||
                    item.description.toLowerCase().includes(q),
            ),
        }))
        .filter((cat) => cat.items.length > 0);
});

// Data Tools
const { tools } = useTools();

// Data Virtual Offices
const { virtualOffices } = useVirtualOffices();

// ─── Hero Slider ──────────────────────────────────────────────────────────────
const heroImages = ["/images/hero-banner.png", "/images/hero-banner-2.png"];

const activeSlide = ref(0);
let sliderTimer = null;

const goToSlide = (i) => {
    activeSlide.value = i;
    // Reset timer saat dot diklik manual
    clearInterval(sliderTimer);
    sliderTimer = setInterval(nextSlide, 5000);
};

const nextSlide = () => {
    activeSlide.value = (activeSlide.value + 1) % heroImages.length;
};

onMounted(() => {
    sliderTimer = setInterval(nextSlide, 5000);
});

onUnmounted(() => {
    clearInterval(sliderTimer);
});
</script>

<template>
    <MainLayout>
        <!-- ===== 1. HERO SECTION ===== -->
        <section
            class="relative min-h-[520px] lg:min-h-[580px] flex items-center overflow-hidden"
        >
            <!-- ── Slide Images ─────────────────────────────────────────────── -->
            <transition-group name="hero-fade">
                <img
                    v-for="(img, i) in heroImages"
                    v-show="i === activeSlide"
                    :key="img"
                    :src="img"
                    alt="Hero Banner"
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="eager"
                />
            </transition-group>

            <div class="absolute inset-0 bg-black/20"></div>

            <!-- ── Content ─────────────────────────────────────────────────── -->
            <div
                class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-14 lg:py-[52px]"
            >
                <div class="max-w-2xl flex flex-col gap-7">
                    <div class="flex flex-col gap-7">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-[#FEFEFE]/30 bg-white/10 backdrop-blur-sm px-4 py-2 w-max"
                        >
                            <span class="text-sm text-[#FEFEFE]">{{
                                t("home.hero.badge")
                            }}</span>
                        </div>
                        <div class="flex flex-col gap-4">
                            <h1
                                class="text-3xl sm:text-4xl lg:text-[38px] font-bold text-[#F9F9F9]"
                            >
                                <span class="block mb-2">{{
                                    t("home.hero.title1")
                                }}</span>
                                <span class="block mb-2">{{
                                    t("home.hero.title2")
                                }}</span>
                                <span class="block">{{
                                    t("home.hero.title3")
                                }}</span>
                            </h1>
                            <p
                                class="text-base lg:text-[16px] text-[#F9F9F9]/90 leading-loose"
                            >
                                {{ t("home.hero.subtitle") }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a
                            href="/kontak"
                            class="inline-flex items-center gap-2 bg-[#9e1f16] hover:bg-red-600 text-white font-semibold text-base px-6 py-3 rounded-lg transition-colors shadow-md"
                        >
                            {{ t("home.hero.cta_primary") }}
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                />
                            </svg>
                        </a>
                        <a
                            href="/layanan"
                            class="inline-flex items-center gap-2 border border-[#F9F9F9] text-[#F9F9F9] hover:bg-white/10 font-semibold text-base px-6 py-3 rounded-lg transition-colors"
                        >
                            {{ t("home.hero.cta_secondary") }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 2. STATS DIVIDER ===== -->
        <section class="relative z-20 mb-5">
            <div class="max-w-3xl ml-auto px-0 sm:px-8 -mt-6 sm:-mt-12">
                <div
                    class="bg-[#9e1f16] rounded-none sm:rounded-xl px-6 py-5 flex flex-col sm:flex-wrap sm:flex-row items-center justify-center gap-y-4 sm:gap-x-6 sm:gap-y-4"
                >
                    <!-- Stat 1 -->
                    <div
                        class="flex items-center gap-4 w-full sm:w-auto justify-center"
                    >
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                {{ t("home.stats.clients.value") }}
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                {{ t("home.stats.clients.label") }}
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>

                    <!-- Divider mobile -->
                    <div class="w-full h-px bg-white/20 block sm:hidden"></div>

                    <!-- Stat 2 -->
                    <div
                        class="flex items-center gap-4 w-full sm:w-auto justify-center"
                    >
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                {{ t("home.stats.experience.value") }}
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                {{ t("home.stats.experience.label") }}
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>

                    <!-- Divider mobile -->
                    <div
                        class="w-full h-px bg-white/20 block mt-5 sm:hidden"
                    ></div>

                    <!-- Stat 3 -->
                    <div
                        class="flex items-center gap-4 w-full sm:w-auto justify-center"
                    >
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                {{ t("home.stats.offices.value") }}
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                {{ t("home.stats.offices.label") }}
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>

                    <!-- Divider mobile -->
                    <div class="w-full h-px bg-white/20 block sm:hidden"></div>

                    <!-- Stat 4 -->
                    <div class="w-full sm:w-auto text-center">
                        <div
                            class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                        >
                            {{ t("home.stats.satisfaction.value") }}
                        </div>
                        <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                            {{ t("home.stats.satisfaction.label") }}
                        </div>
                    </div>
                </div>

                <!-- Speech bubble tail — desktop only -->
                <svg
                    class="absolute -bottom-[30px] right-[10%] z-10 hidden sm:block"
                    width="35"
                    height="32"
                    viewBox="0 0 100 32"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                >
                    <path d="M0 0 H100 L15 28 Q5 30 3 25 Z" fill="#9e1f16" />
                </svg>
            </div>
        </section>

        <!-- ===== 3. VIP LINE ===== -->
        <section class="py-8">
            <div class="bg-[#9e1f16]">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 sm:px-6 lg:px-[84px] py-6 sm:py-0 sm:h-[160px] gap-5 sm:gap-0"
                >
                    <!-- Teks -->
                    <div class="inline-flex items-end gap-2">
                        <div class="flex flex-col gap-2 sm:gap-3">
                            <!-- Title badge - berdiri sendiri -->
                            <div
                                class="inline-flex items-center justify-center self-start rounded-lg bg-[#FEFEFE] px-3 sm:px-4 py-1.5 sm:py-2"
                            >
                                <span
                                    class="text-[18px] sm:text-[28px] font-bold leading-tight text-primary whitespace-nowrap"
                                >
                                    {{ t("home.vip.title") }}
                                </span>
                            </div>

                            <!-- Subtitle + disclaimer sejajar di desktop -->
                            <div
                                class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-3"
                            >
                                <p
                                    class="text-[14px] sm:text-[24px] font-semibold leading-tight text-[#F9F9F9]"
                                >
                                    {{ t("home.vip.subtitle") }}
                                </p>
                                <p
                                    class="relative -top-0.1 sm:-top-1 text-[11px] sm:text-[14px] font-light italic text-[#F9F9F9] underline"
                                >
                                    {{ t("home.vip.disclaimer") }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dekoratif arrow — desktop only -->
                    <svg
                        class="hidden lg:block flex-shrink-0"
                        width="250"
                        height="200"
                        viewBox="0 0 90 100"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M40 0L0 50L40 100"
                            stroke="#F9F9F9"
                            stroke-width="20"
                            stroke-linecap="butt"
                            stroke-linejoin="miter"
                        />
                    </svg>

                    <!-- CTA Button — tampil di semua ukuran -->
                    <a
                        href="/konsultasi"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg border border-[#F9F9F9] bg-[#9e1f16] px-[23px] h-[48px] sm:h-[52px] hover:bg-[#d13a3f] transition-colors"
                    >
                        <span
                            class="text-[15px] sm:text-[16px] font-semibold leading-[24px] text-[#F9F9F9]"
                        >
                            {{ t("home.vip.cta") }}
                        </span>
                        <svg
                            class="w-5 h-5 sm:w-6 sm:h-6 text-[#F9F9F9]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== 4. SUB-SERVICE CARDS ===== -->
        <section id="layanan" class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col gap-8">
                    <div
                        class="flex items-center justify-between border-b border-[#D9DAD8] pb-4"
                    >
                        <h2
                            class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                        >
                            {{ t("home.services.title") }}
                        </h2>
                        <div
                            class="hidden sm:flex items-center border border-[#D9DAD8] rounded-lg shadow-sm bg-[#FEFEFE] w-[300px] h-[46px] overflow-hidden"
                        >
                            <div
                                class="flex items-center gap-2 flex-grow px-3 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-[#42443D] flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                                <input
                                    v-model="serviceSearch"
                                    type="text"
                                    :placeholder="t('home.services.search')"
                                    class="w-full border-none bg-transparent p-0 text-[14px] text-[#42443D] placeholder-[#42443D] focus:ring-0 focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        v-for="(category, catIdx) in filteredCategories"
                        :key="catIdx"
                        class="flex flex-col gap-4"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img
                                    src="/icons/ft-docs.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h3
                                    class="text-[18px] font-bold leading-[27px] text-[#1A1B18]"
                                >
                                    {{ category.title }}
                                </h3>
                            </div>
                            <a
                                :href="category.path"
                                class="hidden sm:inline-flex items-center gap-2 rounded-lg px-4 py-3 text-[14px] font-semibold text-primary hover:bg-[#9e1f16]/5 transition-colors"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                {{ t("home.services.seeMore") }}
                            </a>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                        >
                            <a
                                v-for="(item, itemIdx) in category.items"
                                :key="itemIdx"
                                :href="item.path"
                                class="group flex flex-col rounded-[14px] border border-[#D9DAD8] bg-[#FEFEFE] p-[15px] backdrop-blur-[13px] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:border-primary/30"
                            >
                                <div class="flex flex-col gap-4 flex-grow">
                                   
                                        <img
                                            :src="item.icon"
                                            class="w-10 h-10 md:w-14 md:h-14"
                                            alt=""
                                        />

                                    <div class="flex flex-col gap-1">
                                        <h4
                                            class="text-[16px] font-bold leading-[24px] text-[#1A1B18]"
                                        >
                                            {{ item.title }}
                                        </h4>
                                        <p
                                            class="text-[14px] leading-[21px] text-[#282925] min-h-[63px]"
                                        >
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>

                                <div class="relative my-4">
                                    <div
                                        class="h-px w-full bg-[#686964] opacity-30"
                                    ></div>
                                </div>

                                <div
                                    class="flex items-start justify-between gap-2"
                                >
                                    <div class="flex flex-col gap-0.5">
                                        <span
                                            class="text-[12px] leading-[18px] text-[#1A1B18]"
                                            >{{ t("home.services.from") }}</span
                                        >
                                        <span
                                            class="text-[24px] font-bold leading-[36px] text-primary"
                                            >{{ item.price }}</span
                                        >
                                    </div>
                                    <span
                                        class="inline-flex items-center border border-[#D9DAD8] rounded bg-[#F9F9F9] px-[7px] py-[3px] text-[12px] leading-[18px] text-[#1A1B18]"
                                        >{{ item.packages }}</span
                                    >
                                </div>

                                <div
                                    class="mt-4 flex items-center justify-center gap-2 rounded-lg border border-primary px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary group-hover:bg-[#9e1f16] group-hover:text-white transition-colors"
                                >
                                    {{ t("home.services.cta") }}
                                    <svg
                                        class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"
                                        />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <a
                            href="/layanan"
                            class="inline-flex items-center justify-center gap-2 border border-primary rounded-lg px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary hover:bg-[#9e1f16] hover:text-white transition-colors"
                        >
                            {{ t("home.services.seeAll") }}
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 5. PROMO SECTION ===== -->
        <section class="bg-[#42443D] pt-[52px] pb-[120px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-[24px] font-bold leading-[36px] text-[#F9F9F9]"
                    >
                        {{ t("home.promo.title") }}
                    </h2>
                    <a
                        href="/promo"
                        class="hidden sm:inline-flex items-center gap-2 border border-[#F9F9F9] rounded-lg px-[11px] py-[11px] h-[44px] text-[14px] font-semibold text-[#F9F9F9] hover:bg-white/10 transition-colors"
                    >
                        {{ t("home.promo.seeAll") }}
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>
                </div>

                <div
                    class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                >
                    <a
                        v-for="i in 4"
                        :key="i"
                        href="/promo"
                        class="group relative flex flex-col rounded-lg bg-[#FEFEFE] p-4 gap-4 hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5"
                    >
                        <div
                            class="relative flex flex-col items-center justify-end h-[80px] gap-2"
                        >
                            <span
                                class="absolute -top-4 left-1/2 -translate-x-1/2 inline-flex items-center justify-center rounded-b-lg bg-[#FED7DA] px-3 py-1 h-[26px] text-[10px] font-semibold leading-[18px] text-[#FB3748]"
                                >{{ t("home.promo.badge") }}</span
                            >
                            <div class="flex flex-col items-center gap-1">
                                <h3
                                    class="text-[16px] font-bold leading-[24px] text-[#1A1B18]"
                                >
                                    {{ t("home.promo.discount") }}
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#1A1B18] text-center"
                                >
                                    {{ t("home.promo.desc") }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-center rounded-lg border border-primary px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary group-hover:bg-[#9e1f16] group-hover:text-white transition-colors"
                        >
                            {{ t("home.promo.cta") }}
                        </div>
                    </a>
                </div>

                <a
                    href="/promo"
                    class="sm:hidden mt-6 inline-flex items-center gap-2 border border-[#F9F9F9] rounded-lg px-[11px] py-[11px] h-[44px] text-[14px] font-semibold text-[#F9F9F9] hover:bg-white/10 transition-colors w-full justify-center"
                >
                    {{ t("home.promo.seeAll") }}
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"
                        />
                    </svg>
                </a>
            </div>
        </section>

        <!-- ===== 6. TENTANG KAMI ===== -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col gap-12">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start"
                    >
                        <!-- Image -->
                        <div>
                            <img
                                src="/images/ft-img-tentang-kami.png"
                                alt="Tim FastTrack di kantor"
                                class="w-full h-[300px] md:h-[386px] rounded-2xl object-cover"
                                loading="lazy"
                            />
                        </div>

                        <!-- Text -->
                        <div class="flex flex-col justify-center">
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-1 w-8 rounded-full bg-primary"
                                    ></div>
                                    <h2
                                        class="text-[28px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        {{ t("home.about.title") }}
                                    </h2>
                                </div>

                                <div class="space-y-3">
                                    <p
                                        class="text-[14px] leading-[22px] text-[#4A4B47] text-justify"
                                    >
                                        {{ t("home.about.desc1") }}
                                    </p>
                                    <p
                                        class="text-[14px] leading-[22px] text-[#4A4B47] text-justify"
                                    >
                                        {{ t("home.about.desc2") }}
                                    </p>
                                </div>

                                <!-- Stats -->
                                <div
                                    class="grid grid-cols-3 divide-x divide-[#D9DAD8] pt-3"
                                >
                                    <div
                                        class="flex flex-col items-center gap-1 px-2"
                                    >
                                        <span
                                            class="text-[19px] sm:text-[26px] font-bold leading-tight text-primary"
                                            >{{
                                                t(
                                                    "home.about.stats.experience.value",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[10px] sm:text-[12px] text-[#4A4B47] text-center leading-tight"
                                            >{{
                                                t(
                                                    "home.about.stats.experience.label",
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        class="flex flex-col items-center gap-1 px-2"
                                    >
                                        <span
                                            class="text-[19px] sm:text-[26px] font-bold leading-tight text-primary"
                                            >{{
                                                t(
                                                    "home.about.stats.offices.value",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[10px] sm:text-[12px] text-[#4A4B47] text-center leading-tight"
                                            >{{
                                                t(
                                                    "home.about.stats.offices.label",
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        class="flex flex-col items-center gap-1 px-2"
                                    >
                                        <span
                                            class="text-[19px] sm:text-[26px] font-bold leading-tight text-primary"
                                            >{{
                                                t(
                                                    "home.about.stats.clients.value",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[10px] sm:text-[12px] text-[#4A4B47] text-center leading-tight"
                                            >{{
                                                t(
                                                    "home.about.stats.clients.label",
                                                )
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                {{ t("home.about.philosophy.title") }}
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18] justify-center"
                            >
                                {{ t("home.about.philosophy.desc") }}
                            </p>
                        </div>
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                {{ t("home.about.vision.title") }}
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18] justify-center"
                            >
                                {{ t("home.about.vision.desc") }}
                            </p>
                        </div>
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                {{ t("home.about.commitment.title") }}
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18] justify-center"
                            >
                                {{ t("home.about.commitment.desc") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 7. WHY CHOOSE US ===== -->
        <section class="py-[52px] bg-[#9e1f16]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8">
                    <div
                        class="flex flex-col items-center gap-2.5 text-center px-4 lg:px-[282px]"
                    >
                        <h2
                            class="text-[28px] font-bold leading-[42px] text-[#F9F9F9]"
                        >
                            {{ t("home.why.title") }}
                        </h2>
                        <p
                            class="text-[16px] leading-[24px] text-[#F9F9F9] max-w-[708px]"
                        >
                            {{ t("home.why.subtitle") }}
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-3 gap-6 self-stretch bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                    >
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >{{ t("home.why.portfolio.value") }}</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        {{ t("home.why.portfolio.title") }}
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        {{ t("home.why.portfolio.desc") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >{{ t("home.why.experience.value") }}</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        {{ t("home.why.experience.title") }}
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        {{ t("home.why.experience.desc") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >{{
                                        t("home.why.satisfaction.value")
                                    }}</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        {{ t("home.why.satisfaction.title") }}
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        {{ t("home.why.satisfaction.desc") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-start self-stretch gap-6">
                        <div
                            class="flex items-center justify-center gap-2.5 self-stretch"
                        >
                            <div class="flex-grow h-px bg-[#D9DAD8]"></div>
                            <span
                                class="text-[24px] font-semibold leading-[36px] text-[#F9F9F9] whitespace-nowrap"
                                >{{ t("home.why.excellence") }}</span
                            >
                            <div class="flex-grow h-px bg-[#D9DAD8]"></div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row items-center self-stretch border border-[#D9DAD8] rounded-xl px-[15px] py-[17px] backdrop-blur-[13px]"
                        >
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-8"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    {{ t("home.why.onTime.title") }}
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[219px]"
                                >
                                    {{ t("home.why.onTime.desc") }}
                                </p>
                            </div>
                            <div
                                class="block sm:hidden w-full h-px bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-8"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    {{ t("home.why.team.title") }}
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[229px]"
                                >
                                    {{ t("home.why.team.desc") }}
                                </p>
                            </div>
                            <div
                                class="block sm:hidden w-full h-px bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-8"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    {{ t("home.why.price.title") }}
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[190px]"
                                >
                                    {{ t("home.why.price.desc") }}
                                </p>
                            </div>
                            <div
                                class="block sm:hidden w-full h-px bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-8"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    {{ t("home.why.national.title") }}
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[210px]"
                                >
                                    {{ t("home.why.national.desc") }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 8. TOOLS SECTION ===== -->
        <section class="pt-[52px] pb-0 bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8 pb-10">
                    <h2
                        class="text-[28px] font-bold leading-[42px] text-[#1A1B18] text-center"
                    >
                        {{ t("home.tools.title") }}
                    </h2>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 self-stretch rounded-b-2xl"
                    >
                        <component
                            :is="tool.url ? 'a' : 'button'"
                            v-for="tool in tools"
                            :key="tool.title"
                            v-bind="
                                tool.url
                                    ? { href: tool.url }
                                    : { type: 'button' }
                            "
                            class="group flex flex-col rounded-[14px] bg-[#FEFEFE] p-5 gap-3 border border-slate-100 hover:shadow-lg hover:shadow-primary/5 hover:-translate-y-0.5 hover:border-primary/20 transition-all duration-200 text-left"
                            @click="handleToolClick(tool)"
                        >
                            <img
                                :src="tool.icon"
                                :alt="tool.title"
                                class="h-12 w-12"
                            />
                            <div class="flex flex-col gap-1 flex-1">
                                <h3
                                    class="text-sm font-bold leading-snug text-[#1A1B18]"
                                >
                                    {{ tool.title }}
                                </h3>
                                <p
                                    class="text-sm leading-relaxed text-[#1A1B18]"
                                >
                                    {{ tool.description }}
                                </p>
                            </div>
                            <span
                                class="text-xs font-semibold text-primary mt-auto pt-1"
                                >{{ tool.cta }}</span
                            >
                        </component>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 9. VIRTUAL OFFICE ===== -->
        <section class="py-[52px] bg-[#42443D]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8">
                    <h2
                        class="text-[28px] font-bold leading-[42px] text-[#F9F9F9] text-center"
                    >
                        {{ t("home.virtualOffice.title") }}
                    </h2>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 self-stretch bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                    >
                        <a
                            v-for="office in virtualOffices"
                            :key="office.name"
                            href="/virtual-office-jakarta"
                            class="group flex flex-col justify-between rounded-xl h-[300px] bg-cover bg-center bg-no-repeat backdrop-blur-[10px] overflow-hidden"
                            :style="{ backgroundImage: `url(${office.image})` }"
                        >
                            <div class="flex flex-col items-end p-4">
                                <span
                                    class="inline-flex items-center justify-center rounded-lg bg-[#32DE83] px-3 py-1 text-[12px] font-semibold leading-[18px] text-[#F9F9F9]"
                                    >{{ office.status }}</span
                                >
                            </div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-white/[0.01] backdrop-blur-[13px] p-4"
                            >
                                <h3
                                    class="text-[16px] font-bold leading-[24px] text-[#F9F9F9]"
                                >
                                    {{ office.name }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <svg
                                        class="w-[18px] h-[18px] text-[#F9F9F9] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[14px] leading-[21px] text-[#F9F9F9]"
                                        >{{ office.location }}</span
                                    >
                                </div>
                                <span
                                    class="inline-flex items-center justify-center self-start rounded-lg bg-[#A8BDED] px-2.5 py-1 text-[12px] leading-[18px] text-[#314777]"
                                    >{{ office.kpp }}</span
                                >
                            </div>
                        </a>
                    </div>

                    <a
                        href="/virtual-office-jakarta"
                        class="inline-flex items-center gap-2 rounded-lg py-3 text-[14px] font-semibold text-white hover:underline"
                    >
                        {{ t("home.virtualOffice.seeAll") }}
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== 10. BLOG ARTIKEL ===== -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <h2
                            class="text-[28px] font-bold leading-[42px] text-[#1A1B18]"
                        >
                            {{ t("home.blog.title") }}
                        </h2>
                        <a
                            href="/artikel"
                            class="inline-flex items-center gap-2 border border-[#9e1f16] text-[#9e1f16] hover:bg-[#9e1f16] hover:text-white font-semibold text-sm px-[11px] h-[44px] rounded-lg transition-colors"
                        >
                            {{ t("home.blog.seeAll") }}
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </div>

                    <div
                        class="flex flex-col gap-6 bg-[#ffffff03] backdrop-blur-[13px] rounded-b-2xl"
                    >
                        <div
                            class="flex flex-col gap-6 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] p-[23px]"
                        >
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <h3
                                        class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        {{ t("home.blog.article1.title") }}
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        {{ t("home.blog.article1.desc") }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center gap-1">
                                    <svg
                                        class="w-5 h-5 text-[#8E8F8B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[12px] font-semibold leading-[18px] text-[#8E8F8B]"
                                        >{{ t("home.blog.date") }}</span
                                    >
                                </div>
                            </div>
                            <a
                                href="/artikel/1"
                                class="inline-flex items-center gap-2 text-[14px] font-semibold text-[#9e1f16] hover:underline w-max"
                            >
                                {{ t("common.button.readMore") }}
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>

                        <div
                            class="flex flex-col gap-6 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] p-[23px]"
                        >
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <h3
                                        class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        {{ t("home.blog.article2.title") }}
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        {{ t("home.blog.article2.desc") }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center gap-1">
                                    <svg
                                        class="w-5 h-5 text-[#8E8F8B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[12px] font-semibold leading-[18px] text-[#8E8F8B]"
                                        >{{ t("home.blog.date") }}</span
                                    >
                                </div>
                            </div>
                            <a
                                href="/artikel/2"
                                class="inline-flex items-center gap-2 text-[14px] font-semibold text-[#9e1f16] hover:underline w-max"
                            >
                                {{ t("home.blog.readMore") }}
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 11. KLIEN & PARTNER ===== -->
        <section
            class="bg-[#42443D] py-10 sm:pt-[52px] sm:pb-10 overflow-hidden"
        >
            <div class="flex flex-col items-center gap-6 sm:gap-8">
                <h2
                    class="text-[24px] sm:text-[28px] font-bold leading-[42px] text-[#F9F9F9]"
                >
                    {{ t("home.clients.title") }}
                </h2>
                <div class="flex flex-col gap-4 sm:gap-5 md:gap-6 w-full">
                    <div
                        v-for="row in marqueeRows"
                        :key="row.id"
                        class="marquee-row"
                    >
                        <div class="marquee-fade-left"></div>
                        <div
                            :class="[
                                'marquee-track',
                                row.reverse
                                    ? 'animate-marquee-reverse'
                                    : 'animate-marquee',
                            ]"
                        >
                            <!-- Set 1 -->
                            <div class="marquee-set">
                                <div
                                    v-for="logo in row.logos"
                                    :key="logo.src"
                                    class="marquee-card"
                                >
                                    <img
                                        :src="logo.src"
                                        :alt="logo.alt"
                                        loading="lazy"
                                    />
                                </div>
                            </div>
                            <!-- Set 2 (duplikat untuk seamless loop) -->
                            <div class="marquee-set" aria-hidden="true">
                                <div
                                    v-for="logo in row.logos"
                                    :key="logo.src + '-dup'"
                                    class="marquee-card"
                                >
                                    <img
                                        :src="logo.src"
                                        :alt="logo.alt"
                                        loading="lazy"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="marquee-fade-right"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 12. AFILIASI ===== -->
        <section class="bg-[#F9F9F9] pt-10 sm:pt-[52px] pb-0 overflow-hidden">
            <div class="flex flex-col items-center gap-6 sm:gap-8">
                <h2
                    class="text-[22px] sm:text-[26px] font-bold leading-[42px] text-[#1A1B18]"
                >
                    {{ t("home.affiliate.title") }}
                </h2>

                <div
                    class="grid grid-cols-2 sm:flex sm:flex-row items-center justify-center gap-4 sm:gap-0 w-full bg-[#ffffff03] backdrop-blur-[13px] rounded-b-2xl overflow-hidden px-6 sm:px-[84px] pb-10 sm:pb-[52px]"
                >
                    <div
                        v-for="(afiliasi, i) in [
                            {
                                src: '/images/afiliasi/ft-af-1.svg',
                                alt: 'Afiliasi 1',
                            },
                            {
                                src: '/images/afiliasi/ft-af-2.svg',
                                alt: 'Afiliasi 2',
                            },
                            {
                                src: '/images/afiliasi/ft-af-5.svg',
                                alt: 'Afiliasi 5',
                            },
                            {
                                src: '/images/afiliasi/ft-af-6.svg',
                                alt: 'Afiliasi 6',
                            },
                            {
                                src: '/images/afiliasi/ft-af-3.svg',
                                alt: 'Afiliasi 3',
                            },
                            {
                                src: '/images/afiliasi/ft-af-4.svg',
                                alt: 'Afiliasi 4',
                            },
                        ]"
                        :key="i"
                        class="flex items-center justify-center h-[52px] sm:h-[64px] sm:px-9 sm:min-w-[120px]"
                        :class="{ 'sm:border-r sm:border-[#D3D1C7]': i < 5 }"
                    >
                        <img
                            :src="afiliasi.src"
                            :alt="afiliasi.alt"
                            class="w-full h-full sm:w-auto sm:max-h-[40px] sm:max-w-[140px] object-contain"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 13. KONTAK SECTION ===== -->
        <section class="py-[52px] bg-[#42443D] mb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Left: Form -->
                    <div
                        class="flex-1 flex flex-col justify-center bg-[#FEFEFE] rounded-xl p-6 gap-8 shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026]"
                    >
                        <h2
                            class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                        >
                            {{ t("home.contact.title") }}
                        </h2>
                        <form @submit.prevent class="flex flex-col gap-4">
                            <div class="flex flex-col gap-4">
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="text"
                                        :placeholder="t('home.contact.name')"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="email"
                                        :placeholder="t('home.contact.email')"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="tel"
                                        :placeholder="
                                            t('home.contact.whatsapp')
                                        "
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="text"
                                        :placeholder="
                                            t('home.contact.business')
                                        "
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                    />
                                </div>
                                <div
                                    class="relative rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <textarea
                                        rows="5"
                                        :placeholder="t('home.contact.message')"
                                        class="w-full px-4 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B] resize-none"
                                        required
                                    ></textarea>
                                    <svg
                                        class="absolute right-3 bottom-3 w-2 h-2 text-[#8E8F8B]"
                                        viewBox="0 0 8 8"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M6 0L8 2V8H6V0ZM0 6L2 8H8V6H0Z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div
                                class="flex items-center h-[53px] rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3"
                            >
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-[14px] h-[14px] rounded-sm outline outline-1 outline-[#D9DAD8] bg-[#F9F9F9] shadow-sm"
                                    ></div>
                                    <span class="text-[12px] text-[#8E8F8B]">{{
                                        t("home.contact.robot")
                                    }}</span>
                                </div>
                                <div class="ml-auto flex flex-col items-center">
                                    <svg
                                        class="w-8 h-8 text-[#4A90D9]"
                                        viewBox="0 0 38 38"
                                        fill="none"
                                    >
                                        <path
                                            d="M19 4C10.716 4 4 10.716 4 19C4 27.284 10.716 34 19 34C27.284 34 34 27.284 34 19"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                        />
                                        <path
                                            d="M34 19C34 15.5 32.5 12.3 30 10"
                                            stroke="#9e1f16"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                    <span
                                        class="text-[8px] text-[#8E8F8B] leading-none"
                                        >reCAPTCHA</span
                                    >
                                    <span
                                        class="text-[6px] text-[#8E8F8B] leading-none"
                                        >Privacy - Terms</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-col gap-4">
                                <label
                                    class="inline-flex items-center gap-[9px]"
                                >
                                    <div
                                        class="w-[14px] h-[14px] flex-shrink-0 rounded-sm outline outline-1 outline-[#D9DAD8] bg-[#F9F9F9] shadow-sm"
                                    ></div>
                                    <span class="text-[12px] text-[#1A1B18]"
                                        >{{ t("home.contact.agree") }}
                                    </span>
                                    <span
                                        class="text-[12px] text-[#9e1f16] cursor-pointer"
                                        >{{ t("home.contact.terms") }}</span
                                    >
                                </label>
                                <button
                                    type="submit"
                                    class="w-full h-[44px] flex items-center justify-center rounded-lg bg-[#9e1f16] hover:bg-red-600 transition-colors"
                                >
                                    <span
                                        class="text-[14px] font-semibold leading-[21px] text-[#F9F9F9]"
                                        >{{ t("home.contact.submit") }}</span
                                    >
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Contact info + Map -->
                    <div class="flex-1 flex flex-col gap-6">
                        <div
                            class="bg-[#FEFEFE] rounded-xl p-6 flex flex-col gap-6 shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026]"
                        >
                            <h3
                                class="text-[18px] font-bold leading-[27px] text-[#1A1B18]"
                            >
                                {{ t("home.contact.hubungi") }}
                            </h3>
                            <div class="flex flex-col gap-4">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#9e1f16] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-white"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        {{ t("home.contact.address") }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#9e1f16] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-white"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="tel:02173885036"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#9e1f16]"
                                        >0217 3885 036</a
                                    >
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#9e1f16] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-white"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="https://wa.me/6282298604144"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#9e1f16]"
                                        >0822 9860 4144</a
                                    >
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#9e1f16] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-white"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="mailto:cs@fasttrack.legal"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#9e1f16]"
                                        >cs@fasttrack.legal</a
                                    >
                                </div>
                            </div>
                        </div>

                        <div
                            class="relative flex-1 min-h-[280px] rounded-xl overflow-hidden shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026]"
                        >
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1274.742131028067!2d106.76295574149604!3d-6.256294232030823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f0f9114766dd%3A0x27b09ab8adc5d72b!2sJakarta%20Business%20Services!5e0!3m2!1sen!2sid!4v1780242883873!5m2!1sen!2sid"
                                class="absolute inset-0 w-full h-full border-0"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                            <a
                                href="https://maps.google.com/?q=Jakarta+Business+Services+Grand+Bintaro"
                                target="_blank"
                                class="absolute top-[10px] right-[14px] z-10 inline-flex items-center gap-1 hover:bg-[#F9F9F9] rounded-lg px-[10px] h-[29px] shadow-sm hover:text-[#9e1f16] text-[#F9F9F9] bg-[#9e1f16] transition-colors"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                    />
                                </svg>
                                <span class="text-[14px] leading-[21px]"
                                    >Open in Maps</span
                                >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 14. GENERATE NAME MODAL ===== -->
        <GeneratorNamaModal
            v-model="showGeneratorModal"
            @check-name="transferToCheckName"
        />

        <!-- ===== 15. CHECK NAME MODAL ===== -->
        <CekNamaModal
            v-model="showCheckNameModal"
            :prefill-name="prefillCheckName"
            @update:modelValue="(val) => !val && closeCheckName()"
        />
    </MainLayout>
</template>

<style scoped>
/* Hero crossfade */
.hero-fade-enter-active,
.hero-fade-leave-active {
    transition: opacity 1s ease;
    position: absolute;
    inset: 0;
}
.hero-fade-enter-from,
.hero-fade-leave-to {
    opacity: 0;
}
.hero-fade-enter-to,
.hero-fade-leave-from {
    opacity: 1;
}
</style>
