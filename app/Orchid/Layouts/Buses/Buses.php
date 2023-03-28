<?php

namespace App\Orchid\Layouts\Buses;

use App\Models\Bus;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;

class Buses extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'buses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID')),
            TD::make('number', 'Number')->sort()->filter(),
            TD::make('brand')->render(function (Bus $model) {
                return $model->brand?->name;
            }),
            TD::make('driver')->render(function (Bus $model) {
                return $model->driver?->first_name . ' ' . $model->driver?->last_name;
            }),
            TD::make('actions', __('Actions'))->render(function (Bus $model) {
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        ModalToggle::make(__('Edit'))->modal('edit')->method('update')->icon('pencil')->modalTitle(__('Edit bus №') . $model->id)->asyncParameters(['model' => $model->id]),
                        Button::make(__('Remove'))->icon('trash')->confirm(__('Are you sure?'))->method('remove', [
                            'id' => $model->id
                        ]),
                    ]);
            })
        ];
    }
}
