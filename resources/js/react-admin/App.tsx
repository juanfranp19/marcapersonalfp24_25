import { Admin, Resource } from 'react-admin';
import { Layout } from "./Layout";
import { ProyectoList, ProyectoEdit, ProyectoShow, ProyectoCreate } from './pages/proyectos';
import ProyectoIcon from '@mui/icons-material/AccountTree';

export const App = () =>
    <Admin layout={Layout}>
       <Resource name="proyectos"
           icon={ProyectoIcon}
           list={ProyectoList}
           edit={ProyectoEdit}
           show={ProyectoShow}
           create={ProyectoCreate}
       />
    </Admin>
;
