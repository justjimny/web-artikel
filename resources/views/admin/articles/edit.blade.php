@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page_title', 'Edit Artikel')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Header -->
    <a href="{{ route('admin.artikel.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Artikel
    </a>

    <!-- Form Container -->
    <div class="bg-white border border-slate-200/60 rounded-3xl p-8 shadow-sm">
        <form id="article-form" action="{{ route('admin.artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="space-y-2 md:col-span-2">
                    <label for="title" class="text-sm font-bold text-slate-700">Judul Artikel</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required placeholder="Masukkan judul artikel" class="w-full px-4 py-2.5 rounded-xl border @error('title') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm transition-all">
                    @error('title')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publisher Name -->
                <div class="space-y-2">
                    <label for="publisher_name" class="text-sm font-bold text-slate-700">Nama Publisher</label>
                    <input type="text" id="publisher_name" name="publisher_name" value="{{ old('publisher_name', $article->publisher_name) }}" required placeholder="Contoh: Admin Redaksi" class="w-full px-4 py-2.5 rounded-xl border @error('publisher_name') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm transition-all">
                    <span class="text-3xs text-slate-400 font-medium block">Nama ini akan dipublikasikan secara publik di atas artikel (fleksibel).</span>
                    @error('publisher_name')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category_id" class="text-sm font-bold text-slate-700">Kategori Artikel</label>
                    <select id="category_id" name="category_id" class="w-full px-4 py-2.5 rounded-xl border @error('category_id') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm bg-white cursor-pointer transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cover Image File Upload / URL -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 block">Foto Cover Artikel</label>
                
                <div class="flex flex-wrap items-center gap-6">
                    <!-- Preview Holder / Preloaded Image -->
                    <div id="image-preview-container" class="w-32 aspect-[16/10] rounded-xl border border-slate-200 overflow-hidden bg-slate-50 flex-shrink-0">
                        @if($article->image_path)
                            <img id="image-preview" src="{{ str_starts_with($article->image_path, 'http') ? $article->image_path : asset('storage/' . $article->image_path) }}" alt="Preview" class="w-full h-full object-cover">
                        @else
                            <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <!-- File picker -->
                    <div class="flex-grow">
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        <label for="image" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-dashed border-slate-300 text-slate-600 hover:text-primary hover:border-primary hover:bg-primary/5 text-sm font-semibold cursor-pointer transition-all">
                            <i class="fa-solid fa-cloud-arrow-up text-base"></i> Ganti Foto Cover
                        </label>
                        <span class="text-3xs text-slate-400 font-medium block mt-2">Biarkan kosong jika tidak ingin mengganti cover. Maks: 2MB.</span>
                    </div>
                </div>
                @error('image')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror

                <!-- URL Image Input -->
                <div class="pt-2 space-y-1.5">
                    <label for="image_url" class="text-xs font-bold text-slate-600 block">Atau gunakan URL Gambar Baru</label>
                    <input type="url" id="image_url" name="image_url" value="{{ old('image_url', str_starts_with($article->image_path, 'http') ? $article->image_path : '') }}" placeholder="https://images.unsplash.com/photo-..." class="w-full px-4 py-2.5 rounded-xl border @error('image_url') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm transition-all">
                    @error('image_url')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content Area (Quill Editor) -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 block">Konten / Deskripsi Artikel</label>
                <!-- Include stylesheet -->
                <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
                <style>
                    /* Style Quill editor container to look modern and match theme */
                    .ql-toolbar.ql-snow {
                        border-color: #e2e8f0;
                        border-top-left-radius: 12px;
                        border-top-right-radius: 12px;
                        background-color: #f8fafc;
                    }
                    .ql-container.ql-snow {
                        border-color: #e2e8f0;
                        border-bottom-left-radius: 12px;
                        border-bottom-right-radius: 12px;
                        min-height: 300px;
                        font-family: inherit;
                        font-size: 0.875rem;
                    }
                    .ql-editor {
                        min-height: 300px;
                    }
                    .ql-editor.ql-blank::before {
                        color: #94a3b8;
                        font-style: normal;
                    }
                </style>
                <div class="w-full">
                    <div id="editor">
                        @php
                            $oldContent = old('content', $article->content);
                            if (!empty($oldContent)) {
                                $decoded = json_decode($oldContent, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded['blocks'])) {
                                    $html = '';
                                    foreach ($decoded['blocks'] as $block) {
                                        if ($block['type'] === 'paragraph' && isset($block['data']['text'])) {
                                            $html .= '<p>' . $block['data']['text'] . '</p>';
                                        } elseif ($block['type'] === 'header' && isset($block['data']['text'])) {
                                            $level = $block['data']['level'] ?? 2;
                                            $html .= '<h' . $level . '>' . $block['data']['text'] . '</h' . $level . '>';
                                        } elseif ($block['type'] === 'list' && isset($block['data']['items'])) {
                                            $tag = ($block['data']['style'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
                                            $html .= '<' . $tag . '>';
                                            foreach ($block['data']['items'] as $item) {
                                                $html .= '<li>' . $item . '</li>';
                                            }
                                            $html .= '</' . $tag . '>';
                                        }
                                    }
                                    echo $html;
                                } else {
                                    echo strip_tags($oldContent) === $oldContent ? nl2br(e($oldContent)) : $oldContent;
                                }
                            }
                        @endphp
                    </div>
                </div>
                <input type="hidden" id="content" name="content" value="{{ old('content', $article->content) }}">
                @error('content')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="border-t border-slate-100 pt-6 flex justify-end gap-3 font-semibold text-sm">
                <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                    Batalkan
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white shadow-md shadow-primary/20 hover:bg-primary-hover hover:shadow-lg transition-all cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!-- Initialize Quill editor & other scripts -->
<script>
    // Initialize Quill editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        },
        placeholder: 'Tulis cerita atau deskripsi lengkap artikel Anda di sini...'
    });

    // Handle form submit
    const form = document.getElementById('article-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get Quill HTML content
        const htmlContent = quill.getSemanticHTML();
        
        // Check if editor is empty
        const textContent = quill.getText().trim();
        if (textContent === '') {
            alert('Konten artikel tidak boleh kosong!');
            return;
        }
        
        document.getElementById('content').value = htmlContent;
        form.submit();
    });

    const imageInput = document.getElementById('image');
    const imageUrlInput = document.getElementById('image_url');
    const previewImage = document.getElementById('image-preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                previewImage.setAttribute('src', this.result);
                previewImage.classList.remove('hidden');
                imageUrlInput.value = ''; // clear url if file is chosen
            });
            reader.readAsDataURL(file);
        }
    });

    imageUrlInput.addEventListener('input', function() {
        if (this.value) {
            previewImage.setAttribute('src', this.value);
            previewImage.classList.remove('hidden');
        }
    });
</script>
@endsection
