<script setup>
import { ref, computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { ElMessage, ElMessageBox } from "element-plus";
import managerLayout from '../Components/managerLayout.vue';
import { Search, Plus, Edit, Delete } from "@element-plus/icons-vue";

const page = usePage();
const assignments = ref(page.props.assignments);
const isModalOpen = ref(false);
const searchQuery = ref("");
const editingAssignmentId = ref(null);

const form = useForm({
  user_id: '',
  equipment_id: ''
});

const openModal = (assignment = null) => {
  if (assignment) {
    editingAssignmentId.value = assignment.id;
    form.user_id = assignment.user_id;
    form.equipment_id = assignment.equipment_id;
  } else {
    editingAssignmentId.value = null;
    form.reset();
  }
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
};

const submit = () => {
  if (editingAssignmentId.value) {
    form.put(route("manager.assign_equipment", editingAssignmentId.value), {
      onSuccess: () => {
        closeModal();
        ElMessage({ message: "Assignment updated successfully", type: "success" });
      },
    });
  } else {
    form.post(route("manager.assign_equipment"), {
      onSuccess: () => {
        closeModal();
        ElMessage({ message: "Equipment assigned successfully", type: "success" });
      },
    });
  }
};
</script>

<template>
  <managerLayout>
    <section class="bg-gray-50 dark:bg-gray-900 p-5">
      <div class="row">
        <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
          <h2 class="text-xl font-semibold">Equipment Assignments</h2>
          <div class="flex items-center space-x-3">
            <el-input v-model="searchQuery" placeholder="Search..." class="w-64" clearable>
              <template #prefix>
                <el-icon><Search /></el-icon>
              </template>
            </el-input>
            <el-button type="primary" @click="openModal()">
              <el-icon><Plus /></el-icon> Assign Equipment
            </el-button>
          </div>
        </div>

        <el-table :data="assignments" stripe highlight-current-row border style="width: 100%">
          <el-table-column prop="user.name" label="User" sortable />
          <el-table-column prop="equipment.name" label="Equipment" sortable />
          <el-table-column prop="assigned_at" label="Assigned At" sortable />
          <el-table-column prop="status" label="Status" sortable>
            <template #default="{ row }">
              <span :class="row.status === 'assigned' ? 'text-green-600' : 'text-gray-500'">
                {{ row.status === 'assigned' ? 'Assigned' : 'Returned' }}
              </span>
            </template>
          </el-table-column>
          <el-table-column label="Actions" width="160">
            <template #default="{ row }">
              <el-button size="small" @click="openModal(row)">
                <el-icon><Edit /></el-icon>
              </el-button>
              <el-button size="small" type="danger" @click="confirmDelete(row.id)">
                <el-icon><Delete /></el-icon>
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <!-- Modal for Assignment -->
        <el-dialog v-model="isModalOpen" :title="editingAssignmentId ? 'Edit Assignment' : 'Assign Equipment'" width="450px" center>
          <el-form :model="form" label-width="100px">
            <el-form-item label="User">
              <el-select v-model="form.user_id" placeholder="Select user" clearable>
                <el-option v-for="user in page.props.users" :key="user.id" :label="user.name" :value="user.id" />
              </el-select>
            </el-form-item>
            <el-form-item label="Equipment">
              <el-select v-model="form.equipment_id" placeholder="Select equipment" clearable>
                <el-option v-for="equipment in page.props.equipments" :key="equipment.id" :label="equipment.name" :value="equipment.id" />
              </el-select>
            </el-form-item>
          </el-form>
          <template #footer>
            <el-button @click="closeModal">Cancel</el-button>
            <el-button type="primary" @click="submit">{{ editingAssignmentId ? 'Update' : 'Assign' }}</el-button>
          </template>
        </el-dialog>
      </div>
    </section>
  </managerLayout>
</template>
