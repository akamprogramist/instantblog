@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.users')</h1>    
    </div>
    <div class="row box-white ms-3 me-3 shadow-sm">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>@lang('admin.id')</th>
                    <th>@lang('admin.name')</th>
                    <th>@lang('admin.username')</th>
                    <th>@lang('admin.role')</th>
                    <th>@lang('admin.edit')</th>
                    <th>@lang('admin.delete')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)      
                <tr> 
                    <th scope="row">{{ $user->id }}</th>
                    <td>
                        <a href="{{url('/profile/' . $user->username)}}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->username}}</td>
                    <td>
                    @if($user->status == "1")
                    <label class="badge bg-danger">@lang('admin.banned')</label>
                    @elseif (isset($user->role))
                    <label class="badge bg-info">{{ $user->role }}</label>
                    @endif
                    </td>
                    <td><a href="{{ url('/users/' . $user->username . '/edit') }}">Edit</a></td>
                    <td><a class="color-delete" href="{{ url('/users/' . $user->username) }}">@lang('admin.delete')</a></td>
                </tr>
                @empty
                @lang('admin.nouser')
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $users->links() }}
        </div>
    </div>
@endsection