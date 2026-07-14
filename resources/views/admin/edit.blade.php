@extends('admin.layout')

@section('title', 'Edit ' . $valentine->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Edit {{ $valentine->name }}</h1>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.update', $valentine) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $valentine->name) }}" required>
            <div class="form-hint">Link: /{{ Str::slug(old('name', $valentine->name)) }}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Foto Profil</label>
            @if($valentine->image)
                <div style="margin-bottom:0.75rem;">
                    <img src="{{ asset('storage/'.$valentine->image) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid var(--border);">
                </div>
            @endif
            <input type="file" name="image" class="form-input" accept="image/*">
            <div class="form-hint">Kosongkan jika tidak ingin mengganti foto.</div>
        </div>

        <div class="form-group">
            <label class="form-label">Foto Gallery (Spinning)</label>
            @if($valentine->photos && count($valentine->photos) > 0)
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:0.75rem;">
                    @foreach($valentine->photos as $photo)
                        <img src="{{ asset('storage/'.$photo) }}" style="width:60px;height:60px;object-fit:cover;border-radius:0.5rem;border:1px solid var(--border);">
                    @endforeach
                </div>
            @endif
            <input type="file" name="photos[]" class="form-input" accept="image/*" multiple>
            <div class="form-hint">Pilih beberapa foto untuk ditampilkan di dome gallery. Max 2MB per foto.</div>
            <div id="photo-preview" style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:0.5rem;"></div>
        </div>

        <div class="form-group">
            <label class="form-label">Audio (Custom)</label>
            @if($valentine->audio)
                <div style="margin-bottom:0.75rem;">
                    <audio controls style="width:100%;height:35px;">
                        <source src="{{ asset('storage/'.$valentine->audio) }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif
            <input type="file" name="audio" class="form-input" accept="audio/*">
            <div class="form-hint">Format: MP3, WAV, OGG. Max 10MB. Kosongkan jika tidak ingin mengganti audio.</div>
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date', $valentine->birth_date?->format('Y-m-d')) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Ucapan Singkat</label>
            <input type="text" name="ucapan" class="form-input" value="{{ old('ucapan', $valentine->ucapan) }}" placeholder="Contoh: Happy Valentine!">
            <div class="form-hint">Ucapan yang muncul di typewriter</div>
        </div>

        <div class="form-group">
            <label class="form-label">Pesan / Description</label>
            <textarea name="message" class="form-input" placeholder="Tulis pesan spesial...">{{ old('message', $valentine->message) }}</textarea>
            <div class="form-hint">Pesan yang muncul di halaman akhir</div>
        </div>

        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="photos[]"]').addEventListener('change', function(e) {
    var preview = document.getElementById('photo-preview');
    preview.innerHTML = '';
    var files = e.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:60px;height:60px;object-fit:cover;border-radius:0.5rem;border:1px solid var(--border);';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endsection
