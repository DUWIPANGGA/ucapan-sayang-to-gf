@extends('admin.layout')

@section('title', 'Data Valentine')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Data Valentine</h1>
        <a href="{{ route('admin.create') }}" class="btn btn-primary">+ Tambah Baru</a>
    </div>

    @if($valentines->count())
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Link</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($valentines as $v)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            @if($v->image)
                                <img src="{{ asset('storage/'.$v->image) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                            @else
                                <div class="avatar">{{ strtoupper(substr($v->name,0,1)) }}</div>
                            @endif
                            <span style="font-weight:500;">{{ $v->name }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="/{{ $v->slug }}" target="_blank" class="badge badge-link">/{{ $v->slug }} &#8599;</a>
                    </td>
                    <td>{{ $v->birth_date ? $v->birth_date->format('d M Y') : '-' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.edit', $v) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('admin.destroy', $v) }}" method="POST" onsubmit="return confirm('Yakin hapus {{ $v->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty">
        <div class="empty-icon">&#128140;</div>
        <div class="empty-text">Belum ada data</div>
        <div class="empty-sub">Klik tombol "Tambah Baru" untuk membuat valentine pertama</div>
    </div>
    @endif
</div>
@endsection
