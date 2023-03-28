<?php

namespace App\Orchid\Screens\Cars;

use App\Models\CarBrand;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

class Brands extends Screen
{
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.car-brands',
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
            'brands' => \App\Models\CarBrand::filters()
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
        return 'Brands';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Create'))->icon('plus')->modal('create')->modalTitle(__('Create brand'))->method('create')
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
                Input::make('name')->title('Name')->max(100)->required()
            ])),
            Layout::modal('edit', Layout::rows([
                Input::make('model.name')->title('Bid')->max(100)->required()
            ]))->async('asyncGetModel'),
            \App\Orchid\Layouts\Cars\Brands::class
        ];
    }

    public function asyncGetModel(\App\Models\CarBrand $model): array
    {
        return [
            'model' => $model
        ];
    }

    public function create(Request $request)
    {
        CarBrand::create([
            'name' => $request->name
        ]);

        Toast::success(__('Brand was created'));
    }

    public function update(\App\Models\CarBrand $model, Request $request)
    {
        $model->update([
            'name' => \Illuminate\Support\Arr::get($request->model, 'name', 'No name'),
        ]);

        Toast::success(__('Brand was updated'));
    }

    public function remove(Request $request)
    {
        \App\Models\CarBrand::find($request->id)->delete();

        Toast::success(__('Brand was removed'));
    }
}
