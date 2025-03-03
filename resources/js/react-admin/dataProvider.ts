// in resources/js/react-admin/dataProvider.ts
import { fetchUtils } from 'react-admin';
import jsonServerProvider from "ra-data-json-server";
import { stringify } from 'query-string';
import { data } from 'autoprefixer';

const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({ Accept: 'application/json' });
    }
    const token = localStorage.getItem('auth') ? JSON.parse(localStorage.getItem('auth')) : undefined
    if (token) {
        options.headers.set('Authorization', `${token.token_type} ${token.access_token}`);
    }
    return fetchUtils.fetchJson(url, options);
};

const dataProvider = jsonServerProvider(
    import.meta.env.VITE_JSON_SERVER_URL,
    httpClient
);

const originalDataProvider = jsonServerProvider(
    import.meta.env.VITE_JSON_SERVER_URL,
    httpClient
);

const apiUrl = `${import.meta.env.VITE_JSON_SERVER_URL}`;

dataProvider.getMany = (resource, params) => {
    const query = {
        id: params.ids,
    };
    const url = `${apiUrl}/${resource}?${stringify(query, { arrayFormat: 'bracket' })}`;
    return httpClient(url).then(({ json }) => ({ data: json }));
};

dataProvider.createToken = (email, password) => {
    return httpClient(`${apiUrl}/tokens`, {
        method: 'POST',
        body: JSON.stringify({ email, password }),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.deleteToken = () => {
    return httpClient(`${apiUrl}/tokens`, {
        method: 'DELETE',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.getIdentity = () => {
    return httpClient(`${apiUrl}/user`, {
        method: 'GET',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.getPermissions = () => {
    return httpClient(`${apiUrl}/user/permissions`, {
        method: 'GET',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.postLogin = (email, password, rememberChecked) => {
    return httpClient(`${apiUrl}/login`, {
        method: 'POST',
        body: JSON.stringify({ email, password, rememberChecked }),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.postLogout = () => {
    return httpClient(`${apiUrl}/logout`, {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.postRegister = (user) => {
    return httpClient(`${apiUrl}/register`, {
        method: 'POST',
        body: JSON.stringify(user),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.postForgotPassword = (email) => {
    return httpClient(`${apiUrl}/forgot-password`, {
        method: 'POST',
        body: JSON.stringify({email}),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
};

dataProvider.update = (resource, params) => {
    if(!anyadirFichero(resource, params)) {
        return originalDataProvider.update(resource, params);
    }

    let formData = new FormData();
    for (const property in params.data) {
        formData.append(`${property}`, `${params.data[property]}`);
    }

    asignarFichero(resource, formData, params)
    formData.append('_method', 'PUT')

    const url = `${apiUrl}/${resource}/${params.id}`
    return httpClient(url, {
        method: 'POST',
        body: formData,
    })
        .then(json => {
            return {
                ...json,
                data: json.json
            }
        })
}

dataProvider.postParticipanteProyecto = (proyectoId, userId) => {
    return httpClient(`${apiUrl}/proyectos/${proyectoId}/participantes`, {
        method: 'POST',
        body: JSON.stringify({estudiante_id: userId}),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.deleteParticipanteProyecto = (proyectoId, userId) => {
    return httpClient(`${apiUrl}/proyectos/${proyectoId}/participantes/${userId}`, {
        method: 'DELETE',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.postCicloEstudianteProyecto = (record, cicloId) => {
    let tablaPrincipal = record.docente_id ? 'proyectos' : 'estudiantes';
    return httpClient(`${apiUrl}/${tablaPrincipal}/${record.id}/ciclos`, {
        method: 'POST',
        body: JSON.stringify({ciclo_id: cicloId}),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.deleteCicloEstudianteProyecto = (record, cicloId) => {
    let tablaPrincipal = record.docente_id ? 'proyectos' : 'estudiantes';
    return httpClient(`${apiUrl}/${tablaPrincipal}/${record.id}/ciclos/${cicloId}`, {
        method: 'DELETE',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.getIdiomasEstudiante = (estudiante_id) => {
    return httpClient(`${apiUrl}/estudiantes/${estudiante_id}/idiomas`, {
        method: 'GET',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.postIdiomaEstudiante = (data) => {
    return httpClient(`${apiUrl}/estudiantes/${data.estudiante_id}/idiomas`, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

dataProvider.deleteIdiomaEstudiante = (estudiante_id, idioma_id) => {
    return httpClient(`${apiUrl}/estudiantes/${estudiante_id}/idiomas/${idioma_id}`, {
        method: 'DELETE',
        headers: new Headers({
            'Content-Type': 'application/json',
            'accept': 'application/json',
        }),
    });
}

function anyadirFichero (resource, params) {
    let ficheroPresente = false
    const recursosConFicheros = ['proyectos', 'users', 'curriculos']
    recursosConFicheros.forEach(recurso => {
        if (recurso === resource && params.data.attachments) ficheroPresente = true
    })
    return ficheroPresente
}

function asignarFichero (resource, formData, params) {

    const recursosConFicheros = [
        {recurso:'proyectos', archivo:'fichero'},
        {recurso:'users', archivo:'avatar'},
        {recurso:'curriculos', archivo:'pdf_curriculum'}
    ]
    recursosConFicheros.forEach(recurso => {
        if (recurso.recurso === resource) formData.append(recurso.archivo, params.data.attachments.rawFile)
    })
}


export { dataProvider };
