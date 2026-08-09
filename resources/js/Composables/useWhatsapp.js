// resources/js/Composables/useWhatsapp.js

export const PHONES = {
    default:        "6282298604144",
    cs2:            "6282318855198",
    sales:          "6281234567890",
    cs:             "6289876543210",
    akta:           "6282298604144",
    perizinan:      "6282298604144",
    imigrasi:       "6282298604144",
    pajak:          "6282298604144",
    visa:           "6282298604144",
    virtual_office: "6282298604144",
    digital:        "6282298604144",
};

// 6282318855198

const MESSAGES = {
    default: (service) =>
        `Halo FASTRACK LEGAL,\nSaya berminat berkonsultasi layanan:\n${service}\nMohon dibantu informasi mengenai persyaratan dan penawaran biaya. Jika memungkinkan, saya juga ingin dijadwalkan untuk konsultasi dengan tim FASTRACK LEGAL.\n\nTerima kasih.`,

    visa: (service) =>
        `Halo FASTRACK LEGAL,\nSaya ingin mengurus ${service}.\nMohon informasi persyaratan dokumen dan estimasi waktu pengurusan.\n\nTerima kasih.`,

    pajak: (service) =>
        `Halo FASTRACK LEGAL,\nSaya membutuhkan bantuan untuk layanan ${service}.\nMohon informasi prosedur dan biaya penanganannya.\n\nTerima kasih.`,

    akta: (service) =>
        `Halo FASTRACK LEGAL,\nSaya ingin mendirikan perusahaan dan membutuhkan bantuan ${service}.\nMohon informasi persyaratan dan estimasi biaya.\n\nTerima kasih.`,

    imigrasi: (service) =>
        `Halo FASTRACK LEGAL,\nSaya membutuhkan bantuan pengurusan ${service}.\nMohon informasi dokumen yang diperlukan dan prosesnya.\n\nTerima kasih.`,
};

function buildMessage(service, agent = "default") {
    const builder = MESSAGES[agent] ?? MESSAGES.default;
    return builder(service);
}

export function waLink(service, options = {}) {
    const agent = options.agent ?? "default";
    const phone = options.phone ?? PHONES[agent] ?? PHONES.default;
    const message = options.greeting ?? buildMessage(service, agent);
    return `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
}

export const useWhatsapp = (agent = "default") => {
    const buildWhatsappLink = (service = "", options = {}) => {
        return waLink(service, { agent, ...options });
    };

    return { buildWhatsappLink };
};

// CARA PENGGUNAAN DI TEMPLATE:
// <!-- Pakai nama produk sebagai subject -->
// :whatsapp-link="buildWhatsappLink(product.name)"

// <!-- Pakai nama tab aktif -->
// :href="buildWhatsappLink(currentSidebar.label)"

// <!-- Custom greeting -->
// :href="buildWhatsappLink('', { greeting: 'Halo, saya ingin tanya promo.' })"

// <!-- Override nomor -->
// :href="buildWhatsappLink(product.name, { phone: '6281122334455' })"