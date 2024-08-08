@extends('layouts.app')

@section('content')

<style>
    .btn-custom {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<h1>Admin</h1>

<!-- 検索フォーム -->
<form method="GET" action="{{ url('/contacts') }}">
    @csrf
    <input type="text" name="name" placeholder="Search by name or email" value="{{ request('name') }}">

    <!-- 性別の選択肢 -->
    <!-- <input type="text" name="gender" placeholder="Search by name or email" value="{{ request('gender') }}"> -->
    <select name="gender">
        <option value="">Select Gender</option>
        <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>All</option>
        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>Male</option>
        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>Female</option>
        <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>Other</option>
    </select>

    <p>{{ request('gender') }}</p>

    <!-- 日付の入力フィールド -->
    <input type="date" name="date" value="{{ request('date') }}">

    <button type="submit">Search</button>
    <button type="button" onclick="resetForm()">Reset</button>

</form>
<!-- エクスポートボタン -->
<form method="GET" action="{{ route('contacts.export') }}">
    @csrf
    <input type="hidden" name="name" value="{{ request('name') }}">
    <input type="hidden" name="gender" value="{{ request('gender') }}">
    <input type="hidden" name="date" value="{{ request('date') }}">
    <button type="submit" class="btn btn-primary btn-custom">Export to Excel</button>
</form>
<!-- <a href="{{ route('contacts.export') }}" class="btn btn-primary btn-custom">Export to Excel</a> -->
<!-- <a href="{{ route('contacts.export', request()->all()) }}">Export to Excel</a> -->

<!-- ページネーション -->
{{ $contacts->links('vendor.pagination.bootstrap-4') }}

<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Tell</th>
            <th>Address</th>
            <th>Building</th>
            <th>Category ID</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->first_name }}</td>
            <td>{{ $contact->last_name }}</td>
            <td>{{ $contact->gender }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->tell }}</td>
            <td>{{ $contact->address }}</td>
            <td>{{ $contact->building }}</td>
            <td>{{ $contact->category_id }}</td>
            <td>
                <!-- モーダルを開くボタン -->
                <button data-id="{{ $contact->id }}" class="show-detail-button">詳細</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<!-- モーダルのHTMLとJavaScriptをインクルード !-->
@include('partials.modal')
@include('partials.modal_script')
<!-- モーダルのHTMLとスタイル -->

<script>
    function resetForm() {
        window.location.href = "{{ url('/contacts') }}";
    }
</script>


@endsection