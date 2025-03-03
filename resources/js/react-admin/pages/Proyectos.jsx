// in resources/js/react-admin/pages/proyectos.jsx
import {
    List,
    SimpleList,
    Datagrid,
    TextField,
    ReferenceField,
    EditButton,
    Edit,
    Create,
    SimpleForm,
    ReferenceInput,
    TextInput,
    NumberField,
    NumberInput,
    FunctionField,
    SelectInput,
    ShowButton,
    Show,
    SimpleShowLayout
  } from 'react-admin';

import { useRecordContext} from 'react-admin';
import { useMediaQuery } from '@mui/material';

const TutorInput = () => (
    <ReferenceInput label="Tutor" source="docente_id" reference="users">
        <SelectInput
        label="Tutor"
        source="docente_id"
        optionText={record => record && `${record.nombre} ${record.apellidos}`} />
    </ReferenceInput>
)
const proyectosFilters = [
    <TextInput source="q" label="Search" alwaysOn />,
    TutorInput(),
];

export const ProyectoList = () => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down('sm'));
  return (
    <List filters={proyectosFilters} >
      {isSmall ? (
        <SimpleList
          primaryText="%{nombre}"
          secondaryText="%{dominio}"
          tertiaryText="%{calificacion}"
          linkType={(record) => (record.canEdit ? 'edit' : 'show')}
        >
          <EditButton />
        </SimpleList>
      ) : (
        <Datagrid bulkActionButtons={false} >
          <TextField source="id" />
          <TextField source="nombre" />
          <TextField source="dominio" />
          <ReferenceField label="Tutor" source="docente_id" reference="users">
            <FunctionField render={record => record && `${record.nombre} ${record.apellidos}`} />
          </ReferenceField>
          <NumberField source="calificacion" />
          <ShowButton />
          <EditButton />
        </Datagrid>
      )}
    </List>
  );
}

export const ProyectoTitle = () => {
  const record = useRecordContext();
  return <span>Proyecto {record ? `"${record.nombre}"` : ''}</span>;
};

export const ProyectoEdit = () => (
    <Edit title={<ProyectoTitle />}>
    <SimpleForm>
        <TextInput source="id" disabled />
        <TextInput source="nombre" />
        <TextInput source="dominio" />
        <TutorInput />
        <NumberInput source="calificacion" />
    </SimpleForm>
    </Edit>
);

export const ProyectoShow = () => (
    <Show>
        <SimpleShowLayout>
            <TextField source="id" />
            <TextField source="nombre" />
            <TextField source="dominio" />
            <ReferenceField label="Tutor" source="docente_id" reference="users">
                <FunctionField render={record => record && `${record.nombre} ${record.apellidos}`} />
            </ReferenceField>
            <NumberField source="calificacion" />
        </SimpleShowLayout>
    </Show>
);

export const ProyectoCreate = () => (
    <Create>
        <SimpleForm>
            <TextInput source="nombre" />
            <TextInput source="dominio" />
            <TutorInput />
            <NumberInput source="calificacion" />
        </SimpleForm>
    </Create>
);
