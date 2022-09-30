<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($user) {
                return '<div class="d-flex justify-content-around">
                <a href="' . route('users.show', $user->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                <a href="' . route('users.edit', $user->id) . '" class="btn btn-primary mx-2"><i class="fa fa-edit"></i></a>
                <form action="' . route('users.destroy', $user->id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger"
                    onclick="return confirm(\'هل انت متأكد من الحذف؟\')"><i class="fa fa-trash"></i></button>
                </form>
                </div>';
            })
            ->editColumn('avatar', function ($user) {
                return '<img src="' . asset('uploads/' . ($user->avatar ?? 'user.jpg')) . '" height="150px">';
            })
            ->editColumn('role', function ($user) {
                return $user->roles->first()->name == 'admin' ? 'مدير' : 'مستخدم';
            })
            ->rawColumns(['action', 'avatar'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('avatar')->title('الصورة'),
            Column::make('name')->title('الاسم'),
            Column::make('role')->title('الصلاحية'),
            Column::make('email')->title('البريد الالكتروني'),
            Column::make('national_id')->title('الرقم القومي'),
            Column::make('phone')->title('رقم الهاتف'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
