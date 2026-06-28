const PHONES = {
    default: '6282298604144',
    sales:   '6281234567890',
    cs:      '6289876543210',
}

function buildMessage(service) {
    return `Halo FASTRACK LEGAL,\nSaya berminat berkonsultasi layanan:\n${service}\nMohon dibantu informasi mengenai persyaratan dan penawaran biaya. Jika memungkinkan, saya juga ingin dijadwalkan untuk konsultasi dengan tim FASTRACK LEGAL.\n\nTerima kasih.`
}

export function waLink(service, options = {}) {
    const phone = options.phone ?? PHONES[options.agent ?? 'default'] ?? PHONES.default
    const message = options.greeting ?? buildMessage(service)
    return `https://wa.me/${phone}?text=${encodeURIComponent(message)}`
}

export { PHONES }