<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurriculoController extends Controller
{
    public function getIndex()
    {
        return view('curriculos.index')
            ->with('curriculos', $this->arrayCurriculos);
    }

    public function getShow($id)
    {
            return view('curriculos.show')
                ->with('curriculos', $this->arrayCurriculos[$id])
                ->with('id', $id);
    }

    public function getCreate()
    {
        return view('curriculos.create');
    }

    public function getEdit($id)
    {
            return view('curriculos.edit')
                ->with('curriculos', $this->arrayCurriculos[$id])
                ->with('id', $id);
    }

    private $arrayCurriculos = [
        [
            'user_id' => 1,
            'video_curriculum' => 'https://www.youtube.com/watch?v=u54uern',
            'texto_curriculum' => "Experiencia en desarrollo web con enfoque en tecnologías front-end.",
        ],
        [
            'user_id' => 2,
            'video_curriculum' => 'https://www.youtube.com/watch?v=v87dfg2',
            'texto_curriculum' => "Habilidades avanzadas en HTML, CSS y JavaScript.",
        ],
        [
            'user_id' => 3,
            'video_curriculum' => 'https://www.youtube.com/watch?v=frt32qe',
            'texto_curriculum' => "Amplia experiencia en el diseño y desarrollo de interfaces de usuario.",
        ],
        [
            'user_id' => 4,
            'video_curriculum' => 'https://www.youtube.com/watch?v=wtrh2we',
            'texto_curriculum' => "Conocimientos sólidos en frameworks front-end como React y Vue.",
        ],
        [
            'user_id' => 5,
            'video_curriculum' => 'https://www.youtube.com/watch?v=qwer123',
            'texto_curriculum' => "Experiencia en integración de API y consumo de servicios web.",
        ],
        [
            'user_id' => 6,
            'video_curriculum' => 'https://www.youtube.com/watch?v=ytgfd32',
            'texto_curriculum' => "Habilidades de resolución de problemas y pensamiento lógico.",
        ],
        [
            'user_id' => 7,
            'video_curriculum' => 'https://www.youtube.com/watch?v=zxvbn23',
            'texto_curriculum' => "Colaborador proactivo y eficiente en entornos de trabajo en equipo.",
        ],
        [
            'user_id' => 8,
            'video_curriculum' => 'https://www.youtube.com/watch?v=asdf456',
            'texto_curriculum' => "Capacidad para aprender rápidamente nuevas tecnologías y conceptos.",
        ],
        [
            'user_id' => 9,
            'video_curriculum' => 'https://www.youtube.com/watch?v=qwerty78',
            'texto_curriculum' => "Comprometido con la mejora continua y el desarrollo profesional.",
        ],
        [
            'user_id' => 10,
            'video_curriculum' => 'https://www.youtube.com/watch?v=mnbvc90',
            'texto_curriculum' => "Comunicación efectiva y habilidades interpersonales.",
        ],
    ];
}


