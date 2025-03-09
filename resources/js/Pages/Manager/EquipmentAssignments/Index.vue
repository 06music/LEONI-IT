<script setup>
import { ref, computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";
import ManagerLayout from "../Components/ManagerLayout.vue";

const page = usePage();
const isModalOpen = ref(false);
const selectedUser = ref(null);
const selectedType = ref(null);
const selectedModel = ref(null);
const selectedComputer = ref(null);
const additionalEquipments = ref([]);
const selectedComputerDetails = ref(null);

const form = useForm({
  user_id: '',
  type_id: '',
  model: '',
  serial_number: '',
  additionalEquipments: []
});

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
  selectedUser.value = null;
  selectedType.value = null;
  selectedModel.value = null;
  selectedComputer.value = null;
  selectedComputerDetails.value = null;
  additionalEquipments.value = [];
};

const addAdditionalEquipment = () => {
  additionalEquipments.value.push({ type: '', model: '', serial_number: '' });
};

const removeAdditionalEquipment = (index) => {
  additionalEquipments.value.splice(index, 1);
};

const submit = () => {
  form.additionalEquipments = additionalEquipments.value;
  form.post(route("manager.assign_equipment"), {
    onSuccess: () => {
      closeModal();
      ElMessage({ message: "Equipment assigned successfully", type: "success" });
    },
  });
};
</script>

<template>
  <ManagerLayout>
    <section class="bg-gray-50 dark:bg-gray-900 p-5">
      <div class="flex justify-between mb-5">
        <h2 class="text-xl font-semibold">Assign Equipment</h2>
        <el-button type="primary" @click="openModal">Assign Equipment</el-button>
      </div>

      <el-dialog v-model="isModalOpen" title="Assign Equipment" width="600px">
        <el-form :model="form" label-width="120px">
          <!-- Select User -->
          <el-form-item label="User">
            <el-select v-model="form.user_id" placeholder="Select user" @change="selectedUser = page.props.users.find(u => u.id == form.user_id)">
              <el-option v-for="user in page.props.users" :key="user.id" :label="user.name" :value="user.id" />
            </el-select>
          </el-form-item>

          <div v-if="selectedUser" class="p-4 bg-gray-100 rounded">
            <p><strong>Name:</strong> {{ selectedUser.name }}</p>
            <p><strong>Email:</strong> {{ selectedUser.email }}</p>
            <p><strong>Role:</strong> {{ selectedUser.role }}</p>
            <p><strong>Site:</strong> {{ selectedUser.site_id }}</p>
          </div>

          <!-- Select Equipment Type -->
          <el-form-item label="Equipment Type">
            <el-select v-model="selectedType" placeholder="Select type" @change="selectedModel = null">
              <el-option v-for="type in page.props.equipment_types" :key="type.id" :label="type.name" :value="type.id" />
            </el-select>
          </el-form-item>

          <!-- Select Model if Workstation -->
          <el-form-item v-if="selectedType == 'workstation'" label="Select Computer">
            <el-select v-model="selectedComputer" placeholder="Select a computer" @change="selectedComputerDetails = page.props.computers.find(c => c.id == selectedComputer)">
              <el-option v-for="computer in page.props.computers" :key="computer.id" :label="computer.computer_name" :value="computer.id" />
            </el-select>
          </el-form-item>

          <!-- Display Selected Computer Details -->
          <div v-if="selectedComputerDetails" class="p-4 bg-gray-100 rounded">
            <p><strong>Computer Name:</strong> {{ selectedComputerDetails.computer_name }}</p>
            <p><strong>Model:</strong> {{ selectedComputerDetails.model }}</p>
            <p><strong>Serial Number:</strong> {{ selectedComputerDetails.serial_number }}</p>
            <p><strong>Operating System:</strong> {{ selectedComputerDetails.operating_system }}</p>
            <p><strong>MAC Address:</strong> {{ selectedComputerDetails.mac_address }}</p>
            <p><strong>IP Address:</strong> {{ selectedComputerDetails.ip_address }}</p>
            <p><strong>RAM:</strong> {{ selectedComputerDetails.ram }}</p>
            <p><strong>Disk Size:</strong> {{ selectedComputerDetails.disk_size }}</p>
          </div>

          <!-- Additional Equipment -->
          <div v-for="(equip, index) in additionalEquipments" :key="index" class="p-4 bg-gray-100 rounded mb-2">
            <el-form-item label="Type">
              <el-select v-model="equip.type" placeholder="Select type">
                <el-option v-for="type in page.props.equipment_types" :key="type.id" :label="type.name" :value="type.id" />
              </el-select>
            </el-form-item>
            <el-form-item label="Model">
              <el-input v-model="equip.model" placeholder="Enter model" />
            </el-form-item>
            <el-form-item label="Serial Number">
              <el-input v-model="equip.serial_number" placeholder="Enter serial number" />
            </el-form-item>
            <el-button type="danger" @click="removeAdditionalEquipment(index)">Remove</el-button>
          </div>

          <el-button type="success" @click="addAdditionalEquipment">+ Add More Equipment</el-button>
        </el-form>

        <template #footer>
          <el-button @click="closeModal">Cancel</el-button>
          <el-button type="primary" @click="submit">Assign</el-button>
        </template>
      </el-dialog>
    </section>
  </ManagerLayout>
</template>
