<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()
            ->paginate(10);

        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        DB::beginTransaction();

        try {

            $service = Service::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            DB::commit();

            return redirect()
                ->route('services.index')
                ->with('success', 'Service created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate(
            $this->validationRules($service->id),
            $this->validationMessages()
        );

        DB::beginTransaction();

        try {

            $service->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            DB::commit();

            return redirect()
                ->route('services.index')
                ->with('success', 'Service updated successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Update failed. Please try again.');
        }
    }

    public function delete($id)
    {
        try {

            $service = Service::findOrFail($id);
            $service->delete();

            return back()->with('success', 'Service deleted successfully.');

        } catch (\Exception $e) {

            return back()->with('error', 'Unable to delete service.');
        }
    }
    public function show($id)
    {
        $service = Service::with([
            'clientServices.client',
            'clientServices.invoices',
            'clientServices.payments'
        ])->findOrFail($id);

        return view('services.show', compact('service'));
    }

    private function validationRules($ignoreId = null)
    {
        $uniqueRule = 'unique:services,name';

        if ($ignoreId) {
            $uniqueRule .= ',' . $ignoreId;
        }

        return [

            'name' => ['required', 'string', 'max:255', $uniqueRule],

            'description' => ['nullable', 'string'],
            ];
    }


    private function validationMessages()
    {
        return [

            'name.required' => 'Service name is required.',
            'name.unique' => 'This service name already exists.',
            'name.max' => 'Service name cannot exceed 255 characters.',
        ];
    }
}