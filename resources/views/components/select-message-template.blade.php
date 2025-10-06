<div
    x-data="{
        insertToTextarea(value) {
            const textarea = findTextarea();
            if (!textarea) {
                console.warn('Textarea not found');
                return;
            }

            const start = textarea.selectionStart ?? textarea.value.length;
            const end = textarea.selectionEnd ?? textarea.value.length;
            const text = textarea.value ?? '';

            // BENTUK TAG DI RUNTIME (Blade tidak akan memproses ini)
            const open = '{' + '{';
            const close = '}' + '}';
            const insert = open + value + close; 

            textarea.value = text.substring(0, start) + insert + text.substring(end);

            // 1) beri event agar Livewire menangkap perubahan
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
            textarea.dispatchEvent(new Event('change', { bubbles: true }));

            // 2) jika ada wire:model, set juga langsung di Livewire (fallback)
            syncToLivewire(textarea, textarea.value);

            // fokus dan letakkan kursor setelah insert
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = start + insert.length;
        },
        handleDrop(event) {
            event.preventDefault();
            const value = event.dataTransfer.getData('text/plain');
            if (!value) return;
            this.insertToTextarea(value);
        }
    }"
    x-init="$el.addEventListener('dragstart', e => e.stopPropagation())"
    class="space-y-2"
>
    <h3 class="text-sm font-semibold text-gray-700">Pilih Variabel</h3>

    <div class="flex flex-wrap gap-2">
        @foreach ($fields as $field)
            <x-filament::badge>
                <span
                    draggable="true"
                    data-key="{{ $field['label'] }}"
                    @dragstart="event.dataTransfer.setData('text/plain', event.target.dataset.key)"
                    @click="insertToTextarea('{{ $field['label'] }}')"
                    class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded text-xs font-mono border"
                >
                    {{ $field['key'] }}
                </span>
            </x-filament::badge>
        @endforeach
    </div>

    <p class="text-xs text-gray-500 mt-2">Klik atau tarik variabel lalu drop ke textarea untuk menambah ke pesan.</p>
</div>

<script>
/**
 * Robust helper: cari textarea yang tepat di DOM.
 * Cek beberapa kemungkinan nama/selector yang sering dipakai Filament/Livewire.
 */
function findTextarea() {
    const candidates = [
        'textarea[name="pesan"]',
        'textarea[name="isi_pesan"]',
        'textarea[name="data.pesan"]',
        'textarea[name="data[pesan]"]',
        'textarea[name="state.pesan"]',
        'textarea[name="form.pesan"]',
        'textarea[wire\\:model]',
        // fallback: first visible textarea inside current modal/form
    ];

    for (const sel of candidates) {
        const el = document.querySelector(sel);
        if (el) return el;
    }

    // fallback: pick the first textarea inside a Filament modal or form section (if only one)
    const modalTextArea = document.querySelector('.filament-modal textarea, .filament-form textarea, form textarea');
    if (modalTextArea) return modalTextArea;

    return document.querySelector('textarea'); // final fallback
}

/**
 * Jika textarea punya atribut wire:model (atau defer/lazy),
 * set langsung ke Livewire component untuk memastikan sinkron.
 */
function syncToLivewire(textarea, value) {
    if (!window.Livewire) return;

    // periksa atribut wire:model (defer/lazy juga)
    const modelAttr = textarea.getAttribute('wire:model')
        || textarea.getAttribute('wire:model.lazy')
        || textarea.getAttribute('wire:model.defer');

    if (!modelAttr) {
        // coba cari wire:model di ancestor input hidden / wrapper
        // (jika Livewire menyimpan state di elemen lain)
        // kita tetap sudah trigger input/change di textarea, itu paling sering cukup
        return;
    }

    // temukan elemen Livewire terdekat
    const lwEl = textarea.closest('[wire\\:id]'); // elemen root Livewire biasanya ada attr wire:id
    if (!lwEl) return;

    const lwId = lwEl.getAttribute('wire:id');
    if (!lwId) return;

    try {
        const component = Livewire.find(lwId);
        if (!component) return;
        // modelAttr bisa berupa "data.pesan" atau "pesan"
        component.set(modelAttr, value);
    } catch (err) {
        console.warn('Livewire set failed', err);
    }
}

// Pasang drag/drop listener ke textarea supaya drop di textarea juga jalan (fallback)
document.addEventListener('DOMContentLoaded', function () {
    const textarea = findTextarea();
    if (!textarea) return;

    textarea.addEventListener('dragover', e => e.preventDefault());
    textarea.addEventListener('drop', function (e) {
        e.preventDefault();
        const value = e.dataTransfer.getData('text/plain');
        if (!value) return;

        // panggil insert via Alpine root jika ada
        const alpineRoot = textarea.closest('[x-data]') || document.querySelector('[x-data]');
        if (alpineRoot && alpineRoot.__x) {
            // Alpine v3: panggil method insertToTextarea
            try {
                alpineRoot.__x.$data.insertToTextarea(value);
                return;
            } catch (err) {
                // fallback ke manual insert
            }
        }

        // fallback: manual insert dan sinkron ke Livewire
        const start = textarea.selectionStart ?? textarea.value.length;
        const end = textarea.selectionEnd ?? textarea.value.length;
        const open = '{' + '{';
        const close = '}' + '}';
        const insert = open + value + close;
        textarea.value = textarea.value.substring(0, start) + insert + textarea.value.substring(end);

        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        textarea.dispatchEvent(new Event('change', { bubbles: true }));
        syncToLivewire(textarea, textarea.value);
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + insert.length;
    });
});
</script>
