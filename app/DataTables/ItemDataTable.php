<?php

namespace App\DataTables;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ItemDataTable extends DataTable
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
            ->addColumn('category', function ($device) {
                return $device->category->name;
            })
            ->addColumn('action', function ($item) {
                return '<div class="d-flex justify-content-around">
                <a href="' . route('items.edit', $item->id) . '" class="btn btn-primary mx-2"><i class="fa fa-edit"></i></a>
                <form action="' . route('items.destroy', $item->id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger"
                    onclick="return confirm(\'هل انت متأكد من الحذف؟\')"><i class="fa fa-trash"></i></button>
                </form>
                </div>';
            })
            ->editColumn('image', function ($item) {
                return '<img src="' . asset('uploads/' . $item->image) . '" height="150px">';
            })
            ->addColumn('created_at', function ($device) {
                return $device->created_at->format('Y-m-d');
            })
            ->addColumn('updated_at', function ($device) {
                return $device->updated_at->format('Y-m-d');
            })
            ->addColumn('quantity', function ($device) {
                if($device->quantity == 0) return '<h2><span class="badge badge-danger">0</span></h2>';
                if($device->quantity < 0) return '<h2><span class="badge badge-warning">' . $device->quantity . '</span></h2>';
                return '<h2><span class="badge badge-success">' . $device->quantity . '</span></h2>';
            })
            ->addColumn('price', function ($device) {
                return '<h3><span class="badge badge-primary rtl">' . $device->price . ' جنيه</span></h3>';
            })
            ->rawColumns(['action', 'image', 'quantity', 'price']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Item $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model): QueryBuilder
    {
        return $model->with('category','inventory')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('item-table')
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
        $columns = [
            Column::make('id'),
            Column::make('name')->title('اسم المنتج'),
            Column::make('image')->title('صورة المنتج'),
            Column::make('category')->title('النوع'),
            Column::make('price')->title('السعر'),
            Column::make('quantity')->title('الكمية'),
        ];

        if (auth()->user()->hasRole('admin')) {
            $columns[] = Column::computed('action')
                ->title('العمليات')
                ->exportable(false)
                ->orderable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center');
            $columns[] = Column::make('created_at')->title('تاريخ الانشاء');
        }
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Item_' . date('YmdHis');
    }
}
