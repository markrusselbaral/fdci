@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('contact.create') }}" class="btn btn-primary" style="margin-bottom: 5px;" id="openModal">Add Contact</a>
            <input type="text" placeholder="search" id="searchInput">
            <div class="card">
                <div class="card-header">Contacts</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">COMPANY</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Pagination buttons will be appended dynamically -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
$(document).ready(function() {
    const fetchData = (page, searchQuery = '') => {
        let url = '/contact?page=' + page;
        if (searchQuery !== '') {
            url += '&search=' + searchQuery;
        }
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response && response.data && response.data.length > 0) {
                    $('tbody').empty();
                    response.data.forEach(function(contact, index) {
                        $('tbody').append(`
                            <tr>
                                <td>${contact.name ? contact.name : ''}</td>
                                <td>${contact.company ? contact.company : ''}</td>
                                <td>${contact.phone ? contact.phone : ''}</td>
                                <td>${contact.email ? contact.email : ''}</td>
                                <td>
                                    <a href="/contact/${contact.id}/edit" class="btn btn-success">Edit</a>
                                    <form action="/contact/${contact.id}/delete" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
                                    <form>
                                </td>
                            </tr>
                        `);
                    });
                    // Add pagination buttons
                    $('.pagination').empty();
                    response.links.forEach(function(link) {
                        if (link.url) {
                            $('.pagination').append(`
                                <button class="page-btn btn btn-link ${link.active ? 'active' : ''}" value="${link.url}">${link.label}</button>
                            `);
                        } else {
                            $('.pagination').append(`
                                <button class="page-btn btn btn-link disabled">${link.label}</button>
                            `);
                        }
                    });

                    $('.page-btn').on('click', function(event) {
                        event.preventDefault();
                        const url = $(this).val();
                        fetchDataByUrl(url);
                    });
                } else {
                    console.error('No data found.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    };

    // Function to fetch data by URL
    const fetchDataByUrl = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response) {
                    // Fetch data by URL and render the table
                    const page = response.current_page;
                    const searchQuery = $('#searchInput').val().trim();
                    fetchData(page, searchQuery);
                } else {
                    console.error('No data found.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    };

    $('#searchInput').on('input', function() {
        const searchQuery = $(this).val().trim();
        fetchData(1, searchQuery);
    });
    fetchData(1);
});

</script>
@endsection
