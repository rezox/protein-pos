@extends('layouts.app')

@section('title')
    - Users List
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users List - Record {{ $users->firstItem() }} to {{ $users->lastItem() }} from {{ $users->total() }} total records
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Branch</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->branch->name }}</td>
                                    <td>{{ title_case($user->role) }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                            Edit
                                        </a>
                                        @if($user->id !== Auth::id())
                                            <form method="post" action="{{ route('users.destroy', $user->id) }}" style="display: inline;" onsubmit="return confirm('Deleting user! Are you sure?');">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ url('users/create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                Add new user
                            </a>
                        </div>
                        <div class="col-xs-6 text-right">
                            {{ $users->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection