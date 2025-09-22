export interface Slider {
  id: number;
  title: string;
  subtitle: string;
  link: string;
  image: string;
}

export interface Service {
  id: number;
  title: string;
  description: string;
    image: string;
}

export interface TeamMember {
  id: number;
  name: string;
  position: string;
  image: string;
  bio:string;
}

 


export interface Project {
  id: number;
  name: string;
  main_image: string | null;
  images: string[];        
  videos: string[];        
  client: string | null;
  description: string | null;
  services: string[]; 
  slug:string;     
  created_at: string;     
}


export interface ProjectPreview {
  id: number;
   name: string;
  main_image: string | null;
  client: string | null;
  description: string | null;
  slug:string; 
}


export interface Testimonial {
  id: number;
  name: string;
  position?: string;
  company?: string;
  content: string;
}


// types/index.ts

export interface Coordinates {
  latitude: number;
  longitude: number;
}

export interface Contact {

  whatsapp: string | null;
  facebook: string | null;
  instagram: string | null;
  address: string | null;
  mobile_number: string | null;
  email: string | null;
  coordinates: Coordinates | null;
}

