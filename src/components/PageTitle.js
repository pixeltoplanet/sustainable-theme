export default function PageTitle({ children }) {

  const componentStyles = {
    // fontSize: '24px',
    fontWeight: 'bold',
    color: '#000',
    marginBottom: '20px',
  };
  
  return <h1 style={componentStyles}>{children}</h1>;
}