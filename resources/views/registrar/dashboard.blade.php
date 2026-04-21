<x-layouts.app>
    <div class="">
      <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                    Pending Student Applications
                </h1>
                <p class="text-gray-500 mt-2 font-medium">
                    Review and approve special exam requests from your students
                </p>
            </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-10" >
            <x-notif-card title="Tertiary Department" count="12" link="{{ route('registrar.courses', 'tertiary') }}" />
            <x-notif-card title="Senior High School (SHS)" count="5" link="#" />
        </div>
    </div>
</x-layouts.app>