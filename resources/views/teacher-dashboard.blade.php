<x-layouts.app>
   
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                    Pending Student Applications
                </h1>
                <p class="text-gray-500 mt-2 font-medium">
                    Review and approve special exam requests from your students
                </p>
            </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    
    <x-card-subject 
        title="Mathematics 101" 
        :count="3" 
        :route="route('teacher.subject')" 
    />

    <x-card-subject 
        title="English 102" 
        :count="2" 
        :route="route('teacher.subject')" 
    />

    <x-card-subject 
        title="Chemistry 101" 
        :count="0" 
        :route="route('teacher.subject')" 
    />

</div>
</x-layouts.app>