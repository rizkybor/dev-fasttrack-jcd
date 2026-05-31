// composables/useModals.js
import { ref } from "vue";

export const useModals = () => {
    const showGeneratorModal = ref(false);
    const showCheckNameModal = ref(false);
    const prefillCheckName = ref("");

    const openGenerator = () => {
        showGeneratorModal.value = true;
    };

    const openCheckName = (name = "") => {
        prefillCheckName.value = name;
        showCheckNameModal.value = true;
    };

    const closeCheckName = () => {
        showCheckNameModal.value = false;
        prefillCheckName.value = ""; // reset agar tidak ada data lama
    };

    const transferToCheckName = (name) => {
        showGeneratorModal.value = false;
        setTimeout(() => openCheckName(name), 150);
    };

    const closeAll = () => {
        showGeneratorModal.value = false;
        showCheckNameModal.value = false;
        prefillCheckName.value = "";
    };

    return {
        showGeneratorModal,
        showCheckNameModal,
        prefillCheckName,
        openGenerator,
        openCheckName,
        closeCheckName,
        transferToCheckName,
        closeAll,
    };
};