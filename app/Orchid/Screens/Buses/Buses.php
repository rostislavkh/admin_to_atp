<?php

namespace App\Orchid\Screens\Buses;

use App\Http\Requests\CreateBus;
use App\Http\Requests\UpdateBus;
use App\Models\Driver;
use App\Models\CarBrand;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\Buses\Buses as BusesBuses;

class Buses extends Screen
{
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.buses',
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'buses' => \App\Models\Bus::filters()
                ->defaultSort('id', 'desc')
                ->paginate(25)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Busses';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Create'))->icon('plus')->modal('create')->modalTitle(__('Create bus'))->method('create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('create', Layout::rows([
                Input::make('number')->title('Number')->max(8)->min(8)->mask('AA9999AA')->required(),
                Relation::make('brand')
                    ->fromModel(CarBrand::class, 'name')
                    ->title('Select car brand')
                    ->required(),
                Relation::make('driver')
                    ->fromModel(Driver::class, 'first_name')
                    ->title('Select driver'),
            ])),
            Layout::modal('edit', Layout::rows([
                Input::make('model.number')->title('Number')->max(8)->min(8)->mask('AA9999AA')->required(),
                Relation::make('model.brand')
                    ->fromModel(CarBrand::class, 'name')
                    ->title('Select car brand')
                    ->required(),
                Relation::make('model.driver')
                    ->fromModel(Driver::class, 'first_name')
                    ->title('Select driver'),
            ]))->async('asyncGetModel'),
            \App\Orchid\Layouts\Buses\Buses::class
        ];
    }

    public function asyncGetModel(\App\Models\Bus $model): array
    {
        return [
            'model' => $model
        ];
    }

    public function create(CreateBus $request)
    {
        \App\Models\Bus::create([
            'number' => $request->number,
            'brand_id' => $request->brand,
            'driver_id' => $request->driver
        ]);

        Toast::success(__('Bus was created'));
    }

    public function update(\App\Models\Bus $model, UpdateBus $request)
    {
        $model->update([
            'name' => \Illuminate\Support\Arr::get($request->model, 'name', 'No number'),
            'brand_id' => \Illuminate\Support\Arr::get($request->model, 'brand', null),
            'driver_id' => \Illuminate\Support\Arr::get($request->model, 'driver', null)
        ]);

        Toast::success(__('Bus was updated'));
    }

    public function remove(Request $request)
    {
        \App\Models\Bus::find($request->id)->delete();

        Toast::success(__('Bus was removed'));
    }
}
