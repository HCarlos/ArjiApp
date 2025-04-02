<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">
                    {{ mode === 'create' ? 'Nuevo Usuario' : 'Editar Usuario: ' +  user.id +' - ' + user.username  }}
                </h2>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8">
                        <button
                            v-for="tab in tabs"
                            :key="tab.id"
                            @click="activeTab = tab.id"
                            class="px-4 py-2 text-sm font-medium"
                            :class="{
                'text-blue-600 border-b-2 border-blue-600': activeTab === tab.id,
                'text-gray-500 hover:text-gray-700': activeTab !== tab.id
              }"
                        >
                            {{ tab.label }}
                        </button>
                    </nav>
                </div>

                <form @submit.prevent="submitForm">
                    <!-- Mostrar errores generales -->
                    <div v-if="$page.props.errors.error" class="mb-4 text-red-500 text-sm">
                        {{ $page.props.errors.error }}
                    </div>

                    <!-- Tab 1: Datos Generales -->
                    <div v-show="activeTab === 1" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Columna Izquierda -->
                            <div class="space-y-4">

                                <div v-if="mode === 'create'">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                                    <input
                                        type="text"
                                        v-model="formData.username"
                                        class="w-full px-3 py-2 border rounded-md"
                                        :class="{ 'border-red-500': $page.props.errors.username }"
                                    />
                                    <p v-if="$page.props.errors.username" class="text-red-500 text-sm mt-1">
                                        {{ $page.props.errors.username }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email principal</label>
                                    <input
                                        type="email"
                                        v-model="formData.email"
                                        class="w-full px-3 py-2 border rounded-md"
                                        :class="{ 'border-red-500': $page.props.errors.email }"
                                    />
                                    <p v-if="$page.props.errors.email" class="text-red-500 text-sm mt-1">
                                        {{ $page.props.errors.email }}
                                    </p>
                                </div>

<!--                                <div v-if="mode === 'create'">-->
<!--                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>-->
<!--                                    <input-->
<!--                                        type="password"-->
<!--                                        v-model="formData.password"-->
<!--                                        class="w-full px-3 py-2 border rounded-md"-->
<!--                                        :class="{ 'border-red-500': $page.props.errors.password }"-->
<!--                                    />-->
<!--                                    <p v-if="$page.props.errors.password" class="text-red-500 text-sm mt-1">-->
<!--                                        {{ $page.props.errors.password }}-->
<!--                                    </p>-->
<!--                                </div>-->

                            </div>

                            <!-- Columna Derecha -->
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ap. Paterno</label>
                                        <input
                                            type="text"
                                            v-model="formData.ap_paterno"
                                            class="w-full px-3 py-2 border rounded-md"
                                            :class="{ 'border-red-500': $page.props.errors.ap_paterno }"
                                        />
                                        <p v-if="$page.props.errors.ap_paterno" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.ap_paterno }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ap. Materno</label>
                                        <input
                                            type="text"
                                            v-model="formData.ap_materno"
                                            class="w-full px-3 py-2 border rounded-md"
                                            :class="{ 'border-red-500': $page.props.errors.ap_materno }"
                                        />
                                        <p v-if="$page.props.errors.ap_materno" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.ap_materno }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre(s)</label>
                                        <input
                                            type="text"
                                            v-model="formData.nombre"
                                            class="w-full px-3 py-2 border rounded-md"
                                            :class="{ 'border-red-500': $page.props.errors.nombre }"
                                        />
                                        <p v-if="$page.props.errors.nombre" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.nombre }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CURP</label>
                                        <input
                                            type="text"
                                            v-model="formData.curp"
                                            class="w-full px-3 py-2 border rounded-md uppercase"
                                            maxlength="18"
                                            @input="formData.curp = $event.target.value.toUpperCase()"
                                            :class="{ 'border-red-500': $page.props.errors.curp }"
                                        />
                                        <p v-if="$page.props.errors.curp" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.curp }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Nacimiento</label>
                                        <input
                                            type="date"
                                            v-model="formData.fecha_nacimiento"
                                            class="w-full px-3 py-2 border rounded-md"
                                            :class="{ 'border-red-500': $page.props.errors.fecha_nacimiento }"
                                        />
                                        <p v-if="$page.props.errors.fecha_nacimiento" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.fecha_nacimiento }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Género</label>
                                        <select
                                            v-model="formData.genero"
                                            class="w-full px-3 py-2 border rounded-md"
                                            :class="{ 'border-red-500': $page.props.errors.genero }"
                                        >
                                            <option value="1">Masculino</option>
                                            <option value="0">Femenino</option>
                                            <option value="2">Otro</option>
                                        </select>
                                        <p v-if="$page.props.errors.genero" class="text-red-500 text-sm mt-1">
                                            {{ $page.props.errors.genero }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Domicilio -->
                    <div v-show="activeTab === 2" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Campos de domicilio con validación similar -->
                            <!-- Ejemplo para calle -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calle</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.calle"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.calle'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.calle']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.calle'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Num. Ext.</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.num_ext"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.num_ext'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.num_ext']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.num_ext'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Num. Int.</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.num_int"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.num_int'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.num_int']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.num_int'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Colonia</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.colonia"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.colonia'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.colonia']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.colonia'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.cp"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.cp'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.cp']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.cp'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Municipio</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.municipio"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.municipio'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.municipio']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.municipio'] }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <input
                                    type="text"
                                    v-model="formData.user_adress.estado"
                                    class="w-full px-3 py-2 border rounded-md"
                                    :class="{ 'border-red-500': $page.props.errors['user_adress.estado'] }"
                                />
                                <p v-if="$page.props.errors['user_adress.estado']" class="text-red-500 text-sm mt-1">
                                    {{ $page.props.errors['user_adress.estado'] }}
                                </p>
                            </div>

              </div>
            </div>

            <!-- Tab 3: Otros Datos -->
            <div v-show="activeTab === 3" class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Lugar de Nacimiento</label>
                    <input
                        type="text"
                        v-model="formData.user_data_extend.lugar_nacimiento"
                        class="w-full px-3 py-2 border rounded-md"
                        :class="{ 'border-red-500': $page.props.errors['user_data_extend.lugar_nacimiento'] }"
                    />
                    <p v-if="$page.props.errors['user_data_extend.lugar_nacimiento']" class="text-red-500 text-sm mt-1">
                        {{ $page.props.errors['user_data_extend.lugar_nacimiento'] }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ocupación</label>
                    <input
                        type="text"
                        v-model="formData.user_data_extend.ocupacion"
                        class="w-full px-3 py-2 border rounded-md"
                        :class="{ 'border-red-500': $page.props.errors['user_data_extend.ocupacion'] }"
                    />
                    <p v-if="$page.props.errors['user_data_extend.ocupacion']" class="text-red-500 text-sm mt-1">
                        {{ $page.props.errors['user_data_extend.ocupacion'] }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profesión</label>
                    <input
                        type="text"
                        v-model="formData.user_data_extend.profesion"
                        class="w-full px-3 py-2 border rounded-md"
                        :class="{ 'border-red-500': $page.props.errors['user_data_extend.profesion'] }"
                    />
                    <p v-if="$page.props.errors['user_data_extend.profesion']" class="text-red-500 text-sm mt-1">
                        {{ $page.props.errors['user_data_extend.profesion'] }}
                    </p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Lugar de Trabajo</label>
                    <input
                        type="text"
                        v-model="formData.user_data_extend.lugar_trabajo"
                        class="w-full px-3 py-2 border rounded-md"
                        :class="{ 'border-red-500': $page.props.errors['user_data_extend.lugar_trabajo'] }"
                    />
                    <p v-if="$page.props.errors['user_data_extend.lugar_trabajo']" class="text-red-500 text-sm mt-1">
                        {{ $page.props.errors['user_data_extend.lugar_trabajo'] }}
                    </p>
                <input
                    type="hidden"
                    v-model="formData.id"
                    class="w-full px-3 py-2 border rounded-md"
                />

                </div>
              </div>
            </div>

            <!-- Navegación entre Tabs -->
            <div class="mt-6 flex justify-between">
              <div>
                <button
                  v-if="activeTab > 1"
                  type="button"
                  @click="activeTab--"
                  class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-md border"
                >
                  Anterior
                </button>
              </div>

              <div class="flex space-x-3">
                <button
                  v-if="activeTab < 3"
                  type="button"
                  @click="activeTab++"
                  class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                  Siguiente
                </button>

                <button
                  type="submit"
                  :disabled="processing"
                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
                >
                  {{ processing ? 'Guardando...' : 'Guardar' }}
                </button>

                <button
                  type="button"
                  @click="closeModal"
                  class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-md border"
                >
                  Cancelar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import {reactive, ref, computed, nextTick, watch, onMounted} from 'vue'
  import { router } from '@inertiajs/vue3'
  import { usePage } from '@inertiajs/vue3'

  const page = usePage()
  const activeTab = ref(1)
  const tabs = [
    { id: 1, label: 'Datos Generales' },
    { id: 2, label: 'Domicilio' },
    { id: 3, label: 'Otros Datos' }
  ]

  const props = defineProps({
    user: {
      type: Object,
      default: () => ({})
    },
    mode: {
      type: String,
      required: true
    }
  })
  // validator: value => ['create', 'edit'].includes(value)

  const emit = defineEmits(['close'])

  // Configuración inicial del formulario
  const initialFormData = computed(() => {
      const defaultData = {
          id: 0,
          username: '',
          email: '',
          password: '',
          nombre: '',
          ap_paterno: '',
          ap_materno: '',
          curp: '',
          fecha_nacimiento: '',
          genero: '1',
          emails: '',
          celulares: '',
          telefonos: '',
          user_adress: {
              calle: '',
              num_ext: '',
              num_int: '',
              colonia: '',
              municipio: '',
              estado: '',
              pais: 'México',
              cp: '',
          },
          user_data_extend: {
              lugar_nacimiento: '',
              ocupacion: '',
              profesion: '',
              lugar_trabajo: ''
          }
      }

      if (props.mode === 'edit') {
          return {
              ...defaultData,
              ...props.user,
              user_adress: {
                  ...defaultData.user_adress,
                  ...(props.user.user_adress || {})
              },
              user_data_extend: {
                  ...defaultData.user_data_extend,
                  ...(props.user.user_data_extend || {})
              },
          }
      }

      return defaultData
  })

  const formData = reactive({
      ...initialFormData.value
  })

const processing = ref(false)
const errors = ref({})

// Watcher para cuando cambia el usuario a editar
watch(() => props.user, (newUser) => {
  if (props.mode === 'edit') {
      // Limpiar errores al recibir nuevo usuario
      errors.value = {}
      // Forzar actualización de Inertia
      router.reload({ only: ['errors'] })
  }
})


// Observar cambios en los errores de la página
watch(() => page.props.errors, (newErrors) => {
  errors.value = newErrors
  // Forzar actualización de la UI
  nextTick(() => {
      activeTab.value = Object.keys(newErrors).some(field =>
          field.startsWith('domicilio')
      ) ? 2 : 1
  })
})

  // onMounted(() => {
  //     if (props.mode === 'edit') {
  //         console.log(defaultData.value);
  //     }
  // })

const submitForm = () => {
  processing.value = true
  errors.value = {} // Limpiar errores anteriores

  const url = props.mode === 'create'
      ? route('users.store')
      : route('users.update', props.user.id)

  const method = props.mode === 'create' ? 'post' : 'put'

  router[method](url, formData, {
      preserveScroll: true,
      onSuccess: () => {
          closeModal()
      },
      onError: (err) => {
          processing.value = false
          errors.value = err
      },
      onFinish: () => {
          processing.value = false
      }
  })
}

// // Cerrar modal
const closeModal = () => {

    // Limpiar errores específicamente al cerrar
    errors.value = {}
    router.reload({ only: ['errors'] })

    emit('close')

  }
</script>

<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(0.5);
}
</style>
