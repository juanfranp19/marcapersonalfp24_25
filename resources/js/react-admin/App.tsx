import { Admin, Resource } from 'react-admin';
import { dataProvider } from './dataProvider';
import { authProvider } from './authProvider';
import { Layout } from "./Layout";
import { ProyectoList, ProyectoEdit, ProyectoShow, ProyectoCreate } from './pages/Proyectos';
import ProyectoIcon from '@mui/icons-material/AccountTree';

export const App = () =>
    <Admin
        layout={Layout}
        dataProvider={dataProvider}
        authProvider={authProvider}
    >
       <Resource name="proyectos"
           icon={ProyectoIcon}
           list={ProyectoList}
           edit={ProyectoEdit}
           show={ProyectoShow}
           create={ProyectoCreate}
       />
    </Admin>
;
