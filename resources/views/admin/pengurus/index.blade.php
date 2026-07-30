@extends('layouts.admin')

@section('page_title', 'Kelola Data Pengurus')
@section('page_subtitle', 'Sisi panel admin untuk manajemen data pengurus.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100">
            {{ session('error') }}
        </div>
    @endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

<div class="bg-white p-6 rounded-2xl border shadow-sm">

<h2 class="text-lg font-bold mb-4">
Tambah Pengurus
</h2>

<form action="{{ route('admin.pengurus.store') }}" method="POST">

@csrf

<div class="space-y-4">

<div>

<label>Jabatan</label>

<select
name="jabatan_id"
class="w-full px-4 py-2 rounded-xl border">

<option value="">Pilih Jabatan</option>

@foreach($jabatans as $jabatan)

<option value="{{ $jabatan->id }}">
{{ $jabatan->name }}
</option>

@endforeach

</select>

</div>

<div>

<label>Nama Pengurus</label>

<input
type="text"
name="name"
class="w-full px-4 py-2 rounded-xl border">

</div>

<div>

<label>Deskripsi</label>

<textarea
name="description"
rows="3"
class="w-full px-4 py-2 rounded-xl border"></textarea>

</div>

<div>

<label>Salary</label>

<input
type="number"
name="salary"
class="w-full px-4 py-2 rounded-xl border">

</div>

<button
class="w-full bg-indigo-600 text-white py-2 rounded-xl">

Simpan

</button>

</div>

</form>

</div>

<div class="lg:col-span-2 bg-white rounded-2xl border shadow-sm">

<div class="p-6 flex justify-between">

<h3 class="font-bold">
Daftar Pengurus
</h3>

<form action="{{ route('admin.pengurus.index') }}" method="GET">

<input
type="text"
name="search"
placeholder="Cari..."

class="border rounded-xl px-3 py-2">

<button
class="bg-slate-900 text-white px-4 py-2 rounded-xl">

Cari

</button>

</form>

</div>

<div class="overflow-x-auto">

<table class="w-full">

<thead>

<tr>

<th>ID</th>

<th>Jabatan</th>

<th>Nama</th>

<th>Deskripsi</th>

<th>Salary</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($pengurus as $item)

<tr>

<td>{{ $item->id }}</td>

<td>{{ $item->jabatan->name }}</td>

<td>{{ $item->name }}</td>

<td>{{ $item->description }}</td>

<td>Rp {{ number_format($item->salary,0,',','.') }}</td>

<td>

<div class="flex gap-2">

<button
onclick="openEditModal(
{{ $item->id }},
{{ $item->jabatan_id }},
'{{ $item->name }}',
'{{ $item->description }}',
{{ $item->salary }}
)"
class="bg-amber-100 px-3 py-1 rounded">

Edit

</button>

<form
action="{{ route('admin.pengurus.destroy',$item->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
onclick="return confirm('Hapus data?')"
class="bg-red-100 px-3 py-1 rounded">

Hapus

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="6"
class="text-center py-10">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

{{-- Modal Edit --}}

<div id="editModal"
class="fixed inset-0 hidden items-center justify-center bg-black/40">

<div class="bg-white p-6 rounded-2xl w-[500px]">

<h2 class="font-bold text-lg mb-4">

Edit Pengurus

</h2>

<form
id="editForm"
method="POST">

@csrf
@method('PUT')

<div class="space-y-3">

<select
id="edit_jabatan"
name="jabatan_id"
class="w-full border rounded-xl px-3 py-2">

@foreach($jabatans as $jabatan)

<option value="{{ $jabatan->id }}">
{{ $jabatan->name }}
</option>

@endforeach

</select>

<input
id="edit_name"
name="name"
class="w-full border rounded-xl px-3 py-2">

<textarea
id="edit_description"
name="description"
class="w-full border rounded-xl px-3 py-2"></textarea>

<input
id="edit_salary"
name="salary"
type="number"
class="w-full border rounded-xl px-3 py-2">

<div class="flex justify-end gap-2">

<button
type="button"
onclick="closeEditModal()">

Batal

</button>

<button
class="bg-indigo-600 text-white px-4 py-2 rounded-xl">

Update

</button>

</div>

</div>

</form>

</div>

</div>

<script>

function openEditModal(id,jabatan,nama,deskripsi,salary){

document.getElementById('edit_jabatan').value=jabatan;

document.getElementById('edit_name').value=nama;

document.getElementById('edit_description').value=deskripsi;

document.getElementById('edit_salary').value=salary;

document.getElementById('editForm').action="/admin/pengurus/"+id;

document.getElementById('editModal').classList.remove('hidden');

document.getElementById('editModal').classList.add('flex');

}

function closeEditModal(){

document.getElementById('editModal').classList.remove('flex');

document.getElementById('editModal').classList.add('hidden');

}

</script>

@endsection