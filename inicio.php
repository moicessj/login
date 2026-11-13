<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="Barcelona" content="width=device-width, initial-scale=1.0">
  <title>FC Barcelona</title>
  <link rel="stylesheet" href="estilo.ccs/estilo.css">
  <link rel="icon" type="image/png" href="barcelona.png">
  <style>
    .parrafo {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      text-align: justify;
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 20px;
      color: #130036;
      border: 1px solid rgba(22, 2, 61, 0.3);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .Titulos {
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 20px;
      color: #130036;
      border: 1px solid rgba(22, 2, 61, 0.3);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      width: 35%;


    }
  </style>
</head>

<body>
  <center>
    <header>
      <br>
      <br>
      <nav>
        <ul>
          <li><a href="#Inicio">Inicio</a></li>
          <li><a href="#Titulos">Titulos</a></li>
          <li><a href="#Historia">Historia</a></li>
          <li><a href="#Estadio-del-club">Estadio del Club</a></li>
          <li><a href="#Filosofia-de-juego">Filosofia de juego</a></li>
          <li><a href="#Jugadores">Jugadores</a></li>
          <li><a href="#Mas-sobre-nosotros">Mas sobre nosotros</a></li>
          <li><a href="#Patrocinadores">Patrocinadores</a></li>
        </ul>
      </nav>
    </header>


    <section id="Inicio">
      <h1><em>FC Barcelona</em></h1>
      <h3><strong><em>"Més que un club"</em></strong></h3>
      <figure>
        <img src="barcelona.png" style="width:300px;height: auto;" class="barca" id="barcelona">
        <figcaption>126 años de historia</figcaption>
      </figure>
    </section>
    <h1>Títulos</h1>
    <section class="Titulos">


      <div class="trofeos">

        <details name="trofeo-grupo">
          <summary>
            <img src="laliga.png" alt="Trofeo de Liga" width="80" height="100">
          </summary>
          <div class="info-trofeo">
            <p><strong>x29</strong> Ligas conquistadas.</p>
            <ul>
              <li>x1929 x1945 x1948</li>
              <li>x1949 x1952 x1953</li>
              <li>x1959 x1960 x1974</li>
              <li>x1985 x1991 x1992</li>
              <li>x1993 x1994 x1998</li>
              <li>x1999 x2005 x2006</li>
              <li>x2009 x2010 x2011</li>
              <li>x2013 x2015 x2016</li>
              <li>x2018 x2019 x2023</li>
              <li>x2025 x2026</li>
            </ul>
          </div>
        </details>
        <details name="trofeo-grupo">
          <summary>
            <img src="ucl.png" alt="Trofeo de Champions League" width="60" height="100">
          </summary>
          <div class="info-trofeo">
            <p><strong>x5</strong> Champions League conquistadas.</p>
            <ul>
              <li>x1992 x2006 x2009</li>
              <li>x2011 x2015</li>
          </div>
        </details>
        <details name="trofeo-grupo">
          <summary>
            <img src="mundial.png" alt="Trofeo Mundial de Clubes" width="40" height="100">
          </summary>
          <div class="info-trofeo">
            <p><strong>x3</strong> Mundiales de clubes en las vitrinas.</p>
            <ul>
              <li>x2009 x2011 x2015</li>
            </ul>
          </div>
        </details>
        <details name="trofeo-grupo">
          <summary>
            <img src="copa.png" alt="Trofeo Copa del Rey" width="60" height="100">
          </summary>
          <div class="info-trofeo">
            <p><strong>x32</strong> Copas del Rey obtenidas.</p>
            <ul>
              <li>x1910 x1912 x1913</li>
              <li>x1920 x1922 x1925</li>
              <li>x1926 x1928 x1942</li>
              <li>x1951 x1952 x1953</li>
              <li>x1957 x1959 x1963</li>
              <li>x1968 x1971 x1978</li>
              <li>x1981 x1983 x1988</li>
              <li>x1990 x1997 x1998</li>
              <li>x2009 x2012 x2015</li>
              <li>x2016 x2017 x2018</li>
              <li>x2021 x2025</li>
            </ul>
          </div>
        </details>

      </div>


    </section>
    <section id="Historia">
      <h1><em>Historia del club</em></h1>

      <!-- <label for="abrir-video" class="boton-video">Ver Video de YouTube</label> -->

      <!-- 2. El checkbox invisible -->
      <!-- <input type="checkbox" id="abrir-video" class="modal-toggle"> -->

      <!-- 3. La ventana modal -->
      <!-- <div class="modal-overlay">
        <div class="modal-contenido"> -->
      <!-- Botón para cerrar -->
      <!-- <label for="abrir-video" class="boton-cerrar">&times;</label> -->

      <!-- Contenedor responsivo para el video de YouTube -->
      <!-- <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/watch?v=_dmHEdE3e1E"
              title="YouTube video player" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
            </iframe>
          </div>
        </div>
      </div> -->

      <div
        style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 12px; padding: 20px; color: #130036; border: 1px solid rgba(22, 2, 61, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); width: 80%; margin: auto;">
         <iframe width="560" height="315" src="https://www.youtube.com/embed/oG1ZTIDPk2s?si=SjgGyQBuFZdYscQo"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      </div>
     
    </section>


    <section id="Estadio-del-club">
      <h1>Estadio del club</h1>
      <h2><em>Spotify Camp Nou</em></h2>
      <figure>
        <img src="camp mou.jfif" class="estadio" id="campnou">
        <figcaption>Spotify Camp Nou</figcaption>
        <figcaption>Distrito de Les Corts (barrio de La Maternitat i Sant Ramon)</figcaption>
      </figure>
    </section>
    <section id="Filosofia-de-juego">

      <h1><em>Filosofia de juego</em></h1>
      <p class="parrafo">La filosofía de juego del Fútbol Club Barcelona, históricamente reconocida bajo la identidad
        del Cruyffismo o el estilo Tiki-Taka, se fundamenta en la posesión del balón como el principal mecanismo tanto
        defensivo como ofensivo. Este enfoque postula que mientras el equipo mantenga el esférico, el rival no puede
        generar peligro, transformando el control del ritmo de juego en una prioridad absoluta. La estrategia no se
        limita a pasar la pelota por pasar, sino a mover constantemente la estructura del rival mediante combinaciones
        rápidas, pases al primer toque y la creación constante de triángulos de pase en todo el terreno de juego.
        <br>
        <br>
        Además de la tenencia del balón, esta idea exige un compromiso colectivo constante en la presión tras pérdida y
        un posicionamiento táctico impecable en la fase de juego de posición. La cantera del club, La Masía, juega un
        rol crucial en la sostenibilidad de este modelo, ya que educa a los futbolistas desde edades tempranas en
        conceptos clave como la interpretación del espacio, la toma de decisiones veloz y la soltura técnica. De este
        modo, la filosofía culé va más allá de un simple esquema táctico: es una identidad cultural que prioriza el
        espectáculo y la creatividad para conseguir la victoria.
      </p>
      <figure>
        <img src="johan.jpg" width="600">
        <figcaption><em>Johan Cruyff como entrenador de un partido del FC Barcelona</em></figcaption>
      </figure>
    </section>


    <section id="Jugadores">

      <section class="carrusel-seccion">
        <h1>Jugadores</h1>

        <div class="carrusel-contenedor">
          <button class="carrusel-control anterior" type="button"
            aria-label="Mostrar jugadores anteriores">&#10094;</button>
          <div class="carrusel-pistas" aria-label="Jugadores del FC Barcelona">

            <!-- Jugador 1 -->
            <div class="carrusel-slide" id="j1">
              <a href="#j16" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-1" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Joan Garcia #1</h3>
                  <img class="n1" src="joan.webp" alt="Joan Garcia">
                  <label for="info-1" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-1" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Portero</p>
                  <p><strong>Dorsal:</strong> #1 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j2" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 2 -->
            <div class="carrusel-slide" id="j2">
              <a href="#j1" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-2" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Joao Cancelo #2</h3>
                  <img class="n1" src="cancelo.webp" alt="Joao Cancelo">
                  <label for="info-2" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-2" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Lateral</p>
                  <p><strong>Dorsal:</strong> #2 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j3" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 3 -->
            <div class="carrusel-slide" id="j3">
              <a href="#j2" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-3" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Cubarsi #5</h3>
                  <img class="n1" src="cubarsi.webp" alt="Cubarsi">
                  <label for="info-3" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-3" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Defensa Central</p>
                  <p><strong>Dorsal:</strong> #5 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j4" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 4 -->
            <div class="carrusel-slide" id="j4">
              <a href="#j3" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-4" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Fermin Lopez #7</h3>
                  <img class="n1" src="fl.webp" alt="Fermin Lopez">
                  <label for="info-4" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-4" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Centrocampista</p>
                  <p><strong>Dorsal:</strong> #7 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j5" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 5 -->
            <div class="carrusel-slide" id="j5">
              <a href="#j4" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-5" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Pedri #8</h3>
                  <img class="n1" src="pedri.webp" alt="Pedri">
                  <label for="info-5" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-5" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Centrocampista</p>
                  <p><strong>Dorsal:</strong> #8 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j6" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 6 -->
            <div class="carrusel-slide" id="j6">
              <a href="#j5" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-6" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Gabriel Jesus #9</h3>
                  <img class="n1" src="gj.webp" alt="Gabriel Jesus">
                  <label for="info-6" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-6" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Delantero</p>
                  <p><strong>Dorsal:</strong> #9 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j7" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 7 -->
            <div class="carrusel-slide" id="j7">
              <a href="#j6" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-7" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Lamine Yamal #10</h3>
                  <img class="n1" src="ly.webp" alt="Lamine Yamal">
                  <label for="info-7" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-7" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Extremo</p>
                  <p><strong>Dorsal:</strong> #10 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j8" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 8 -->
            <div class="carrusel-slide" id="j8">
              <a href="#j7" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-8" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Raphinha #11</h3>
                  <img class="n1" src="raphinha.webp" alt="Raphinha">
                  <label for="info-8" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-8" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Extremo</p>
                  <p><strong>Dorsal:</strong> #11 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j9" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 9 -->
            <div class="carrusel-slide" id="j9">
              <a href="#j8" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-9" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Xavi Espart #12</h3>
                  <img class="n1" src="xavi.webp" alt="Xavi Espart">
                  <label for="info-9" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-9" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Lateral / Mediocampista</p>
                  <p><strong>Dorsal:</strong> #12 | <strong>Estado:</strong> Suplente</p>
                </div>
              </div>
              <a href="#j10" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 10 -->
            <div class="carrusel-slide" id="j10">
              <a href="#j9" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-10" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Adeyemi #14</h3>
                  <img class="n1" src="adeyemi.webp" alt="Adeyemi">
                  <label for="info-10" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-10" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Extremo</p>
                  <p><strong>Dorsal:</strong> #14 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j11" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 11 -->
            <div class="carrusel-slide" id="j11">
              <a href="#j10" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-11" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Rodri #16</h3>
                  <img class="n1" src="rodri.webp" alt="Rodri">
                  <label for="info-11" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-11" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Pivote</p>
                  <p><strong>Dorsal:</strong> #16 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j12" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 12 -->
            <div class="carrusel-slide" id="j12">
              <a href="#j11" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-12" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Anthony Gordon #17</h3>
                  <img class="n1" src="gordon.webp" alt="Anthony Gordon">
                  <label for="info-12" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-12" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Extremo</p>
                  <p><strong>Dorsal:</strong> #17 | <strong>Estado:</strong> Suplente</p>
                </div>
              </div>
              <a href="#j13" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 13 -->
            <div class="carrusel-slide" id="j13">
              <a href="#j12" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-13" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Gerard Martin #18</h3>
                  <img class="n1" src="martin.webp" alt="Gerard Martin">
                  <label for="info-13" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-13" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Lateral Izquierdo</p>
                  <p><strong>Dorsal:</strong> #18 | <strong>Estado:</strong> Suplente</p>
                </div>
              </div>
              <a href="#j14" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 14 -->
            <div class="carrusel-slide" id="j14">
              <a href="#j13" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-14" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Dani Olmo #20</h3>
                  <img class="n1" src="olmo.webp" alt="Dani Olmo">
                  <label for="info-14" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-14" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Mediapunta</p>
                  <p><strong>Dorsal:</strong> #20 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j15" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 15 -->
            <div class="carrusel-slide" id="j15">
              <a href="#j14" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-15" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Kounde #23</h3>
                  <img class="n1" src="kounde.webp" alt="Kounde">
                  <label for="info-15" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-15" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Lateral / Central</p>
                  <p><strong>Dorsal:</strong> #23 | <strong>Estado:</strong> Titular</p>
                </div>
              </div>
              <a href="#j16" class="flecha next">&#10095;</a>
            </div>

            <!-- Jugador 16 -->
            <div class="carrusel-slide" id="j16">
              <a href="#j15" class="flecha prev">&#10094;</a>
              <div class="tarjeta-jugador">
                <input type="checkbox" id="info-16" class="toggle-info">
                <div class="contenedor-imagen">
                  <h3>Eric Garcia #24</h3>
                  <img class="n1" src="erid.webp" alt="Eric Garcia">
                  <label for="info-16" class="btn-abrir">Ver Información</label>
                </div>
                <div class="info-inferior">
                  <label for="info-16" class="cerrar-info">&times;</label>
                  <h4>Ficha Técnica</h4>
                  <p><strong>Posición:</strong> Defensa Central</p>
                  <p><strong>Dorsal:</strong> #24 | <strong>Estado:</strong> Suplente</p>
                </div>
              </div>
              <a href="#j1" class="flecha next">&#10095;</a>
            </div>

          </div>
          <button class="carrusel-control siguiente" type="button"
            aria-label="Mostrar jugadores siguientes">&#10095;</button>
        </div>
      </section>
    </section>

    <footer>
      <div class="contenedor-footer">
        <section id="Mas-sobre-nosotros">
          <h1>Mas sobre nosotros</h1>
          <div class="patro">
            <div class="sobre-nosotros">
              <a href="https://www.instagram.com/fcbarcelona/?hl=es" target="_blank"><img src="ig.png"
                  style="width:100px;height: auto;"></a>
              <a href="https://www.tiktok.com/@fcbarcelona?lang=esS" target="_blank"><img src="tiktok.png"
                  style="width:100px;height: auto;"></a>
            </div>
        </section>

        <section id="Patrocinadores">
          <h1>Patrocinadores</h1>
          <div class="patro">
            <div class="patrocinadores">
              <a href="https://open.spotify.com/" target="_blank"><img src="spotify.png"
                  style="width:100px;height: auto;"></a>
              <a href="https://www.nike.com/us/es/" target="_blank"><img src="nike.png"
                  style="width:150px;height: auto;"></a>
            </div>
        </section>
      </div>
      </div>
    </footer>

  </center>
  <script>
    const carrusel = document.querySelector(".carrusel-contenedor");
    const pista = carrusel.querySelector(".carrusel-pistas");
    const anterior = carrusel.querySelector(".carrusel-control.anterior");
    const siguiente = carrusel.querySelector(".carrusel-control.siguiente");

    anterior.addEventListener("click", () => {
      const alInicio = pista.scrollLeft <= 0;
      pista.scrollTo({
        left: alInicio ? pista.scrollWidth : pista.scrollLeft - pista.clientWidth,
        behavior: "smooth"
      });
    });

    siguiente.addEventListener("click", () => {
      const alFinal = pista.scrollLeft + pista.clientWidth >= pista.scrollWidth - 1;
      pista.scrollTo({
        left: alFinal ? 0 : pista.scrollLeft + pista.clientWidth,
        behavior: "smooth"
      });
    });
  </script>
</body>