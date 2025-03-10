<script setup>
import { ref, computed } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";
import ManagerLayout from '../Components/ManagerLayout.vue'; // Import ManagerLayout

const page = usePage();
const isModalOpen = ref(false);
const isEditMode = ref(false);
const selectedAssignmentId = ref(null);
const additionalEquipments = ref([]);
const selectedUser = ref(null);

// Form
const form = useForm({
  user_id: '',
  type_id: '',
  model: '',
  serial_number: '',
  additionalEquipments: []
});

// Computed: Check if Selected Type is Workstation
const isWorkstation = computed(() => {
  const selectedType = page.props.equipment_types.find(t => t.id === form.type_id);
  return selectedType && selectedType.name.toLowerCase() === 'workstation';
});

// Computed: Get Selected Computer Details
const selectedComputerDetails = computed(() => {
  return page.props.computers.find(c => c.id === form.model) || null;
});

// Handle User Selection
const setSelectedUser = () => {
  selectedUser.value = page.props.users.find(u => u.id === form.user_id) || null;
};

// Reset Equipment Selection when Type Changes
const resetEquipmentSelection = () => {
  form.model = '';
  form.serial_number = '';
};

// Handle Computer Selection
const setSelectedComputer = () => {
  const computer = page.props.computers.find(c => c.id === form.model);
  if (computer) {
    form.model = computer.model;
    form.serial_number = computer.serial_number;
  }
};

// Open Modal for Adding Equipment
const openModal = () => {
  isModalOpen.value = true;
  isEditMode.value = false;
  selectedAssignmentId.value = null;
  form.reset();
  additionalEquipments.value = [];
};

// Open Modal for Editing Equipment
const editAssignment = (assignment) => {
  isModalOpen.value = true;
  isEditMode.value = true;
  selectedAssignmentId.value = assignment.id;

  form.user_id = assignment.user_id;
  form.type_id = assignment.equipment_id;
  form.model = assignment.model || '';
  form.serial_number = assignment.serial_number || '';
  form.additionalEquipments = assignment.additionalEquipments || [];
  setSelectedUser();
};

// Close Modal and Reset
const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
  additionalEquipments.value = [];
  selectedUser.value = null;
  isEditMode.value = false;
  selectedAssignmentId.value = null;
};

// Submit Form for Add/Edit
const submit = () => {
  form.additionalEquipments = additionalEquipments.value;

  if (isEditMode.value) {
    // Update existing assignment
    form.put(route("manager.equipment_assignments.update", selectedAssignmentId.value), {
      onSuccess: () => {
        closeModal();
        ElMessage({ message: "Equipment updated successfully", type: "success" });
      },
    });
  } else {
    // Create new assignment
    form.post(route("manager.equipment_assignments.store"), {
      onSuccess: () => {
        closeModal();
        ElMessage({ message: "Equipment assigned successfully", type: "success" });
      },
    });
  }
};

// Delete Assignment
const deleteAssignment = (id) => {
  if (confirm("Are you sure you want to delete this assignment?")) {
    router.delete(route("manager.equipment_assignments.destroy", id), {
      onSuccess: () => {
        ElMessage({ message: "Assignment deleted successfully", type: "success" });
      },
    });
  }
};

// Add Extra Equipment
const addAdditionalEquipment = () => {
  additionalEquipments.value.push({ type: '', model: '', serial_number: '' });
};

// Remove Extra Equipment
const removeAdditionalEquipment = (index) => {
  additionalEquipments.value.splice(index, 1);
};
</script>

<template>
  <ManagerLayout>
    <section class="bg-gray-50 dark:bg-gray-900 p-5">
      <div class="flex justify-between mb-5">
        <h2 class="text-xl font-semibold">Equipment Assignments</h2>
        <el-button type="primary" @click="openModal">Assign Equipment</el-button>
      </div>

      <!-- Equipment List Table -->
      <el-table :data="page.props.assignments" style="width: 100%">
        <el-table-column prop="user.name" label="User" width="180" />
        <el-table-column prop="equipment.name" label="Equipment" width="180" />
        <el-table-column prop="status" label="Status" width="120" />
        <el-table-column label="Actions" width="250">
          <template #default="{ row }">
            <el-button type="warning" @click="editAssignment(row)">Edit</el-button>
            <el-button type="danger" @click="deleteAssignment(row.id)">Delete</el-button>
          </template>
        </el-table-column>
      </el-table>

      <!-- Assign Equipment Modal -->
      <el-dialog v-model="isModalOpen" :title="isEditMode ? 'Edit Equipment' : 'Assign Equipment'" width="600px">
        <el-form :model="form" label-width="120px">
          <!-- Select User -->
          <el-form-item label="User">
            <el-select v-model="form.user_id" placeholder="Select user" @change="setSelectedUser">
              <el-option v-for="user in page.props.users" :key="user.id" :label="user.name" :value="user.id" />
            </el-select>
          </el-form-item>

          <!-- Display Selected User Details -->
          <div v-if="selectedUser" class="p-4 bg-gray-100 rounded">
            <p><strong>Name:</strong> {{ selectedUser.name }}</p>
            <p><strong>Email:</strong> {{ selectedUser.email }}</p>
            <p><strong>Role:</strong> {{ selectedUser.role }}</p>
            <p><strong>Site:</strong> {{ selectedUser.site_id }}</p>
          </div>

          <!-- Select Equipment Type -->
          <el-form-item label="Equipment Type">
            <el-select v-model="form.type_id" placeholder="Select type" @change="resetEquipmentSelection">
              <el-option v-for="type in page.props.equipment_types" :key="type.id" :label="type.name" :value="type.id" />
            </el-select>
          </el-form-item>

          <!-- If Type is Workstation, Show Computer Selection -->
          <el-form-item v-if="isWorkstation" label="Select Computer">
            <el-select v-model="form.model" placeholder="Select a computer" @change="setSelectedComputer">
              <el-option v-for="computer in page.props.computers" :key="computer.id" :label="computer.computer_name" :value="computer.id" />
            </el-select>
          </el-form-item>

          <!-- If Equipment is NOT Workstation, Show Serial Number and Model Input -->
          <template v-else>
            <el-form-item label="Model">
              <el-input v-model="form.model" placeholder="Enter model" />
            </el-form-item>
            <el-form-item label="Serial Number">
              <el-input v-model="form.serial_number" placeholder="Enter serial number" />
            </el-form-item>
          </template>

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
          <el-button type="primary" @click="submit">{{ isEditMode ? 'Update' : 'Assign' }}</el-button>
        </template>
      </el-dialog>
    </section>
  </ManagerLayout>
</template>
