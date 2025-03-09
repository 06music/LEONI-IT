<template>
    <AdminLayout>
        <section class="bg-gray-50 dark:bg-gray-900 p-5">
            <div class="row">
                <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
                    <h2 class="text-xl font-semibold">Equipment Types Management</h2>
                    <div class="flex items-center space-x-3">
                        <el-input v-model="searchQuery" placeholder="Search..." class="w-64" clearable>
                            <template #prefix>
                                <el-icon><Search /></el-icon>
                            </template>
                        </el-input>
                        <el-button type="primary" @click="openModal(null)">
                            <el-icon><Plus /></el-icon> Add Type
                        </el-button>
                    </div>
                </div>

                <el-table :data="filteredTypes" stripe highlight-current-row border style="width: 100%">
                    <el-table-column prop="name" label="Type Name" sortable />
                    <el-table-column prop="description" label="Description" sortable />
                    <el-table-column label="Actions" width="160">
                        <template #default="{ row }">
                            <el-tooltip content="Edit" placement="top">
                                <el-button size="small" @click="openModal(row)">
                                    <el-icon><Edit /></el-icon>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Delete" placement="top">
                                <el-button size="small" type="danger" @click="confirmDelete(row.id)">
                                    <el-icon><Delete /></el-icon>
                                </el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>

                <el-dialog v-model="showModal" :title="modalTitle" width="450px" center>
                    <el-form :model="form" label-width="100px">
                        <el-form-item label="Name">
                            <el-input v-model="form.name" clearable placeholder="Enter type name" />
                        </el-form-item>
                        <el-form-item label="Description">
                            <el-input v-model="form.description" clearable placeholder="Enter description" />
                        </el-form-item>
                    </el-form>
                    <template #footer>
                        <el-button @click="showModal = false">Cancel</el-button>
                        <el-button type="primary" @click="submit">{{ modalButton }}</el-button>
                    </template>
                </el-dialog>
            </div>
        </section>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import AdminLayout from "../Components/AdminLayout.vue";
import { Search, Plus, Edit, Delete } from "@element-plus/icons-vue";

const props = defineProps({ types: Array });

const showModal = ref(false);
const searchQuery = ref("");
const editingTypeId = ref(null);

const form = useForm({
    name: "",
    description: "",
});

const filteredTypes = computed(() =>
    props.types.filter(
        (type) =>
            type.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            type.description?.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
);

const modalTitle = computed(() => (editingTypeId.value ? "Edit Type" : "Add Type"));
const modalButton = computed(() => (editingTypeId.value ? "Update" : "Save"));

const openModal = (type) => {
    if (type) {
        editingTypeId.value = type.id;
        form.name = type.name;
        form.description = type.description;
    } else {
        editingTypeId.value = null;
        form.reset();
    }
    showModal.value = true;
};

const submit = () => {
    if (editingTypeId.value) {
        form.put(route("equipment-types.update", editingTypeId.value), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage.success("Type updated successfully.");
            },
        });
    } else {
        form.post(route("equipment-types.store"), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage.success("Type added successfully.");
            },
        });
    }
};

const confirmDelete = (id) => {
    ElMessageBox.confirm("Are you sure you want to delete this type?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    })
        .then(() => {
            form.delete(route("equipment-types.destroy", id), {
                onSuccess: () => ElMessage.success("Type deleted successfully."),
            });
        })
        .catch(() => {});
};
</script>
