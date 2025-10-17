<x-layouts.app :title="__('Crear Usuario')">
    <p>¿Que tipo de Usuario?</p>

    <ul class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-4 w-64">
        <li>
            <a href="#"
            class="block px-4 py-2 text-gray-700 dark:text-gray-200 
                    hover:bg-blue-100 dark:hover:bg-blue-900/40 
                    hover:text-blue-600 dark:hover:text-blue-400 
                    rounded-lg transition-colors duration-200">
            Jefe de Franquicia
            </a>
        </li>
        <li>
            <a href="{{route('users.franchisee.create')}}"
            class="block px-4 py-2 text-gray-700 dark:text-gray-200 
                    hover:bg-blue-100 dark:hover:bg-blue-900/40 
                    hover:text-blue-600 dark:hover:text-blue-400 
                    rounded-lg transition-colors duration-200">
            Franquiciado
            </a>
        </li>
        <li>
            <a href="#"
            class="block px-4 py-2 text-gray-700 dark:text-gray-200 
                    hover:bg-blue-100 dark:hover:bg-blue-900/40 
                    hover:text-blue-600 dark:hover:text-blue-400 
                    rounded-lg transition-colors duration-200">
            Empleado
            </a>
        </li>
    </ul>


</x-layouts.app>